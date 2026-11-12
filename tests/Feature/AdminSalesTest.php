<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarInquiry;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/** Admin side of cars for sale, car requests, subscription plans and subscriptions. */
class AdminSalesTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        Role::findOrCreate('Admin', 'web');

        return tap(User::factory()->create())->assignRole('Admin');
    }

    private function carData(array $overrides = []): array
    {
        return array_merge([
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2020,
            'mileage' => 30000,
            'price' => 15000,
            'old_price' => 16500,
            'fuel' => 'hybrid',
            'transmission' => 'automatic',
            'color' => 'Blue',
            'description' => 'Very clean.',
            'status' => 'available',
            'is_featured' => '1',
            'image' => UploadedFile::fake()->image('car.jpg', 800, 600),
        ], $overrides);
    }

    private function planData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Gold',
            'slug' => 'gold',
            'description' => 'Everything',
            'icon' => 'fa-crown',
            'price_monthly' => 120,
            'price_yearly' => '',
            'features' => "A\nB",
            'excluded_features' => '',
            'is_popular' => '1',
            'is_active' => '1',
            'sort_order' => '5',
        ], $overrides);
    }

    // ------------------------------------------------------------ access

    public function test_new_admin_sections_are_protected(): void
    {
        foreach (['cars.index', 'cars.create', 'car-inquiries.index', 'plans.index', 'plans.create', 'subscriptions.index'] as $route) {
            $this->get(route($route))->assertRedirect(route('login'));
        }

        $this->actingAs(User::factory()->create());
        foreach (['cars.index', 'plans.index', 'subscriptions.index'] as $route) {
            $this->get(route($route))->assertForbidden();
        }
    }

    public function test_admin_sees_the_new_sections(): void
    {
        $this->actingAs($this->admin());

        foreach (['admin-home', 'cars.index', 'cars.create', 'car-inquiries.index', 'plans.index', 'plans.create', 'subscriptions.index'] as $route) {
            $this->get(route($route))->assertOk();
        }
    }

    // ------------------------------------------------------------ cars

    public function test_admin_can_add_a_car_with_an_uploaded_photo(): void
    {
        Storage::fake('uploads');
        $this->actingAs($this->admin());

        $this->post(route('cars.store'), $this->carData())->assertRedirect(route('cars.index'))->assertSessionHas('success');

        $car = Car::firstOrFail();
        $this->assertSame('Toyota Corolla', $car->title);
        $this->assertTrue($car->is_featured);
        $this->assertStringStartsWith('cars/', $car->image);
        Storage::disk('uploads')->assertExists($car->image);
    }

    public function test_car_photo_is_required_and_cannot_be_a_link(): void
    {
        Storage::fake('uploads');
        $this->actingAs($this->admin());

        $this->post(route('cars.store'), $this->carData(['image' => null]))->assertSessionHasErrors('image');
        $this->post(route('cars.store'), $this->carData(['image' => 'https://example.com/car.jpg']))->assertSessionHasErrors('image');
        $this->post(route('cars.store'), $this->carData(['image' => UploadedFile::fake()->create('virus.exe', 10)]))->assertSessionHasErrors('image');

        $this->assertDatabaseCount('cars', 0);
    }

    public function test_car_form_is_validated(): void
    {
        Storage::fake('uploads');
        $this->actingAs($this->admin());

        $this->post(route('cars.store'), $this->carData([
            'brand' => '', 'year' => 1900, 'price' => 0, 'fuel' => 'steam', 'status' => 'gone',
        ]))->assertSessionHasErrors(['brand', 'year', 'price', 'fuel', 'status']);
    }

    public function test_old_price_must_be_higher_than_price(): void
    {
        Storage::fake('uploads');
        $this->actingAs($this->admin());

        $this->post(route('cars.store'), $this->carData(['price' => 15000, 'old_price' => 15000]))->assertSessionHasErrors('old_price');
        $this->post(route('cars.store'), $this->carData(['old_price' => '']))->assertSessionHasNoErrors();
    }

    public function test_admin_can_update_a_car_and_replace_its_photo(): void
    {
        Storage::fake('uploads');
        $this->actingAs($this->admin());
        $this->post(route('cars.store'), $this->carData());
        $car = Car::firstOrFail();
        $oldPhoto = $car->image;

        // without a new photo the old one stays
        $this->put(route('cars.update', $car), $this->carData(['price' => 14000, 'status' => 'sold', 'is_featured' => '0', 'image' => null]))
            ->assertRedirect(route('cars.index'));
        $car->refresh();
        $this->assertSame(14000, $car->price);
        $this->assertSame('sold', $car->status);
        $this->assertFalse($car->is_featured);
        $this->assertSame($oldPhoto, $car->image);

        // with a new photo the old file is removed
        $this->put(route('cars.update', $car), $this->carData(['image' => UploadedFile::fake()->image('new.png')]));
        $newPhoto = $car->fresh()->image;
        $this->assertNotSame($oldPhoto, $newPhoto);
        Storage::disk('uploads')->assertMissing($oldPhoto);
        Storage::disk('uploads')->assertExists($newPhoto);
    }

    public function test_deleting_a_car_removes_its_photo_and_requests(): void
    {
        Storage::fake('uploads');
        $this->actingAs($this->admin());
        $this->post(route('cars.store'), $this->carData());
        $car = Car::firstOrFail();
        $car->inquiries()->create(['name' => 'A B', 'phone' => '+380950660959']);

        $this->delete(route('cars.destroy', $car))->assertRedirect(route('cars.index'));

        $this->assertDatabaseCount('cars', 0);
        $this->assertDatabaseCount('car_inquiries', 0);
        Storage::disk('uploads')->assertMissing($car->image);
    }

    public function test_bundled_demo_car_photos_are_never_deleted(): void
    {
        $this->actingAs($this->admin());
        $car = Car::create(['brand' => 'A', 'model' => 'B', 'year' => 2020, 'price' => 1000, 'image' => 'assets/auto-sale/car1.jpg']);

        $this->delete(route('cars.destroy', $car));

        $this->assertFileExists(public_path('assets/auto-sale/car1.jpg'));
    }

    public function test_cars_list_can_be_filtered_by_status(): void
    {
        $this->actingAs($this->admin());
        Car::create(['brand' => 'Aaa', 'model' => 'Alpha', 'year' => 2020, 'price' => 1000, 'status' => 'available']);
        Car::create(['brand' => 'Bbb', 'model' => 'Bravo', 'year' => 2020, 'price' => 1000, 'status' => 'sold']);

        $this->get(route('cars.index', ['status' => 'sold']))->assertSee('Bravo')->assertDontSee('Alpha');
    }

    // ------------------------------------------------------------ car requests

    public function test_admin_can_process_car_requests(): void
    {
        $this->actingAs($this->admin());
        $car = Car::create(['brand' => 'Toyota', 'model' => 'Corolla', 'year' => 2020, 'price' => 15000]);
        $inquiry = $car->inquiries()->create(['name' => 'Mary Jones', 'phone' => '+380950660959', 'message' => 'Is it available?']);

        $this->get(route('car-inquiries.index'))->assertOk()->assertSee('Mary Jones')->assertSee('Toyota Corolla')->assertSee('Is it available?');

        $this->patch(route('car-inquiries.update', $inquiry), ['status' => 'contacted'])->assertSessionHas('success');
        $this->assertSame(CarInquiry::STATUS_CONTACTED, $inquiry->fresh()->status);

        $this->patch(route('car-inquiries.update', $inquiry), ['status' => 'bogus'])->assertSessionHasErrors('status');

        $this->delete(route('car-inquiries.destroy', $inquiry));
        $this->assertDatabaseCount('car_inquiries', 0);
    }

    // ------------------------------------------------------------ plans

    public function test_admin_can_manage_plans(): void
    {
        $this->actingAs($this->admin());

        $this->post(route('plans.store'), $this->planData())->assertRedirect(route('plans.index'));
        $plan = SubscriptionPlan::firstOrFail();
        $this->assertNull($plan->price_yearly);
        $this->assertTrue($plan->is_popular);
        $this->assertSame(['A', 'B'], $plan->feature_list);

        $this->put(route('plans.update', $plan), $this->planData(['name' => 'Gold Plus', 'price_yearly' => '1200', 'is_popular' => '0', 'is_active' => '0']))
            ->assertRedirect(route('plans.index'));
        $plan->refresh();
        $this->assertSame('Gold Plus', $plan->name);
        $this->assertSame(1200, $plan->price_yearly);
        $this->assertFalse($plan->is_popular);
        $this->assertFalse($plan->is_active);

        $this->delete(route('plans.destroy', $plan))->assertRedirect(route('plans.index'));
        $this->assertDatabaseCount('subscription_plans', 0);
    }

    public function test_plan_form_is_validated(): void
    {
        $this->actingAs($this->admin());
        SubscriptionPlan::create(['name' => 'Taken', 'slug' => 'taken', 'price_monthly' => 10, 'features' => 'x']);

        $this->post(route('plans.store'), $this->planData(['name' => '', 'price_monthly' => 0, 'features' => '', 'icon' => 'fa-nope']))
            ->assertSessionHasErrors(['name', 'price_monthly', 'features', 'icon']);

        $this->post(route('plans.store'), $this->planData(['slug' => 'taken']))->assertSessionHasErrors('slug');
    }

    public function test_slug_is_generated_from_the_name_when_empty(): void
    {
        $this->actingAs($this->admin());

        $this->post(route('plans.store'), $this->planData(['name' => 'Super Care', 'slug' => '']))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('subscription_plans', ['slug' => 'super-care']);
    }

    public function test_deleting_a_plan_keeps_existing_subscriptions(): void
    {
        $this->actingAs($this->admin());
        $plan = SubscriptionPlan::create(['name' => 'Gold', 'slug' => 'gold', 'price_monthly' => 120, 'features' => 'A']);
        $subscription = Subscription::create([
            'subscription_plan_id' => $plan->id, 'plan_name' => 'Gold', 'billing_period' => 'monthly', 'price' => 120,
            'name' => 'John Smith', 'phone' => '+380950660959', 'car' => 'BMW',
        ]);

        $this->delete(route('plans.destroy', $plan))->assertRedirect(route('plans.index'));

        $subscription->refresh();
        $this->assertNull($subscription->subscription_plan_id);
        $this->assertSame('Gold', $subscription->plan_name);
        $this->get(route('subscriptions.show', $subscription))->assertOk()->assertSee('plan deleted');
    }

    // ------------------------------------------------------------ subscriptions

    private function subscription(array $overrides = []): Subscription
    {
        return Subscription::create(array_merge([
            'plan_name' => 'Standard', 'billing_period' => 'monthly', 'price' => 59,
            'name' => 'John Smith', 'phone' => '+380950660959', 'car' => 'Toyota Camry',
        ], $overrides));
    }

    public function test_admin_can_open_and_filter_subscriptions(): void
    {
        $this->actingAs($this->admin());
        $pending = $this->subscription(['name' => 'Pending Pete']);
        $this->subscription(['name' => 'Active Ann', 'status' => 'active']);

        $this->get(route('subscriptions.index'))->assertSee('Pending Pete')->assertSee('Active Ann');
        $this->get(route('subscriptions.index', ['status' => 'active']))->assertSee('Active Ann')->assertDontSee('Pending Pete');
        $this->get(route('subscriptions.show', $pending))->assertOk()->assertSee($pending->reference)->assertSee('Toyota Camry');
    }

    public function test_activating_a_subscription_sets_the_term(): void
    {
        $this->actingAs($this->admin());
        $subscription = $this->subscription(['billing_period' => 'yearly', 'price' => 590]);

        $this->put(route('subscriptions.update', $subscription), ['status' => 'active', 'starts_at' => '', 'ends_at' => ''])
            ->assertRedirect(route('subscriptions.show', $subscription));

        $subscription->refresh();
        $this->assertSame('active', $subscription->status);
        $this->assertTrue($subscription->starts_at->isToday());
        $this->assertTrue($subscription->ends_at->isSameDay(today()->addYear()));
    }

    public function test_admin_can_set_custom_dates_and_cancel(): void
    {
        $this->actingAs($this->admin());
        $subscription = $this->subscription();

        $this->put(route('subscriptions.update', $subscription), ['status' => 'active', 'starts_at' => '2026-03-01', 'ends_at' => '2026-04-01']);
        $this->assertSame('2026-03-01', $subscription->fresh()->starts_at->toDateString());
        $this->assertSame('2026-04-01', $subscription->fresh()->ends_at->toDateString());

        $this->put(route('subscriptions.update', $subscription), ['status' => 'cancelled', 'starts_at' => '2026-03-01', 'ends_at' => '2026-04-01']);
        $this->assertSame('cancelled', $subscription->fresh()->status);
    }

    public function test_subscription_update_is_validated(): void
    {
        $this->actingAs($this->admin());
        $subscription = $this->subscription();

        $this->put(route('subscriptions.update', $subscription), ['status' => 'whatever', 'starts_at' => '2026-05-01', 'ends_at' => '2026-04-01'])
            ->assertSessionHasErrors(['status', 'ends_at']);
    }

    public function test_admin_can_delete_a_subscription(): void
    {
        $this->actingAs($this->admin());
        $subscription = $this->subscription();

        $this->delete(route('subscriptions.destroy', $subscription))->assertRedirect(route('subscriptions.index'));
        $this->assertDatabaseCount('subscriptions', 0);
    }

    public function test_dashboard_counts_new_requests(): void
    {
        $this->actingAs($this->admin());
        $car = Car::create(['brand' => 'A', 'model' => 'B', 'year' => 2020, 'price' => 1000]);
        $car->inquiries()->create(['name' => 'A B', 'phone' => '+380950660959']);
        $this->subscription();

        $this->get(route('admin-home'))->assertOk()->assertSee('New car requests')->assertSee('Subscriptions to confirm');
    }
}

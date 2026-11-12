<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Public forms are submitted with fetch(): Laravel answers JSON (no redirect, no page reload). */
class AjaxFormsTest extends TestCase
{
    use RefreshDatabase;

    private function car(array $overrides = []): Car
    {
        return Car::create(array_merge(['brand' => 'Toyota', 'model' => 'Corolla', 'year' => 2020, 'price' => 15000], $overrides));
    }

    private function plan(): SubscriptionPlan
    {
        return SubscriptionPlan::create([
            'name' => 'Standard', 'slug' => 'standard', 'price_monthly' => 59, 'price_yearly' => 590, 'features' => 'Oil change',
        ]);
    }

    public function test_booking_form_returns_json_success(): void
    {
        $this->postJson(route('repair.store'), [
            'name' => 'John Smith', 'phone' => '+380 95 066 09 59', 'car' => 'Toyota Camry', 'comment' => 'Strange engine noise',
        ])->assertOk()->assertJsonStructure(['message']);

        $this->assertDatabaseCount('repairs', 1);
    }

    public function test_booking_form_returns_422_with_field_errors(): void
    {
        $this->postJson(route('repair.store'), ['name' => '', 'phone' => 'abc'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'phone', 'car', 'comment']);

        $this->assertDatabaseCount('repairs', 0);
    }

    public function test_contact_form_json(): void
    {
        $this->postJson(route('contact.store'), [])->assertStatus(422)->assertJsonValidationErrors(['name', 'phone', 'message', 'consent']);

        $this->postJson(route('contact.store'), [
            'name' => 'Mary Jones', 'phone' => '+380950660959', 'message' => 'Do you repair hybrids?', 'consent' => '1',
        ])->assertOk()->assertJsonStructure(['message']);
    }

    public function test_car_request_json(): void
    {
        $car = $this->car();

        $this->postJson(route('car.inquire', $car), [])->assertStatus(422)->assertJsonValidationErrors(['name', 'phone', 'consent']);

        $this->postJson(route('car.inquire', $car), ['name' => 'Mary Jones', 'phone' => '+380950660959', 'consent' => '1'])
            ->assertOk()->assertJsonStructure(['message']);
        $this->assertDatabaseCount('car_inquiries', 1);
    }

    public function test_requesting_a_sold_car_returns_a_json_error(): void
    {
        $car = $this->car(['status' => Car::STATUS_SOLD]);

        $this->postJson(route('car.inquire', $car), ['name' => 'Mary Jones', 'phone' => '+380950660959', 'consent' => '1'])
            ->assertStatus(422)->assertJsonValidationErrors('car');
    }

    public function test_checkout_returns_the_confirmation_markup(): void
    {
        $plan = $this->plan();

        $response = $this->postJson(route('plan.subscribe', $plan), [
            'billing_period' => 'yearly', 'name' => 'John Smith', 'phone' => '+380 67 111 22 33', 'car' => 'Skoda Octavia', 'consent' => '1',
        ])->assertOk()->assertJsonStructure(['message', 'reference', 'html']);

        $subscription = Subscription::firstOrFail();
        $this->assertSame($subscription->reference, $response->json('reference'));
        $this->assertStringContainsString($subscription->reference, $response->json('html'));
        $this->assertStringContainsString('$590', $response->json('html'));
        $this->assertStringNotContainsString('+380 67 111 22 33', $response->json('html'));
    }

    public function test_checkout_validation_errors_are_json(): void
    {
        $plan = $this->plan();

        $this->postJson(route('plan.subscribe', $plan), ['billing_period' => 'weekly'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['billing_period', 'name', 'phone', 'car', 'consent']);
    }

    public function test_rate_limit_answers_json(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->postJson(route('repair.store'), []);
        }

        $this->postJson(route('repair.store'), [])->assertStatus(429);
    }

    public function test_forms_still_work_without_javascript(): void
    {
        // a normal (non-AJAX) post keeps redirecting back with the flash message
        $this->post(route('repair.store'), [
            'name' => 'John Smith', 'phone' => '+380 95 066 09 59', 'car' => 'Toyota Camry', 'comment' => 'Strange engine noise',
        ])->assertRedirect(route('home_auto').'#contacts')->assertSessionHas('success');
    }

    public function test_catalog_markup_supports_async_filtering(): void
    {
        $this->car();

        $this->get(route('offer'))
            ->assertSee('id="catalog-results"', false)
            ->assertSee('data-ajax-filters', false)
            ->assertSee('data-filters-reset', false);
    }
}

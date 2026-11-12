<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionFlowTest extends TestCase
{
    use RefreshDatabase;

    private function plan(array $overrides = []): SubscriptionPlan
    {
        return SubscriptionPlan::create(array_merge([
            'name' => 'Standard',
            'slug' => 'standard',
            'description' => 'Best balance',
            'icon' => 'fa-bolt',
            'price_monthly' => 59,
            'price_yearly' => 590,
            'features' => "Oil change\nDiagnostics",
            'excluded_features' => 'Pick-up',
            'is_popular' => true,
            'is_active' => true,
            'sort_order' => 1,
        ], $overrides));
    }

    private function checkout(array $overrides = []): array
    {
        return array_merge([
            'billing_period' => 'monthly',
            'name' => 'John Smith',
            'phone' => '+380 95 066 09 59',
            'email' => 'john@example.com',
            'car' => 'Toyota Camry 2015',
            'notes' => 'Start next week please',
            'consent' => '1',
        ], $overrides);
    }

    // ------------------------------------------------------------ plans page

    public function test_plans_page_lists_active_plans_only(): void
    {
        $this->plan();
        $this->plan(['name' => 'Hidden plan', 'slug' => 'hidden', 'is_active' => false]);

        $this->get(route('plan'))
            ->assertOk()
            ->assertSee('Standard')
            ->assertSee('Most popular')
            ->assertSee('Oil change')
            ->assertSee('Pick-up')
            ->assertDontSee('Hidden plan');
    }

    public function test_plans_page_shows_both_prices_and_the_yearly_saving(): void
    {
        $this->plan();

        $this->get(route('plan'))
            ->assertSee('<sup>$</sup>59', false)
            ->assertSee('<sup>$</sup>590', false)
            ->assertSee('Save 17% vs monthly');
    }

    public function test_plans_page_without_plans_shows_a_message(): void
    {
        $this->get(route('plan'))->assertOk()->assertSee('Plans are coming soon');
    }

    public function test_choose_buttons_follow_the_selected_period(): void
    {
        $plan = $this->plan();

        $this->get(route('plan', ['period' => 'yearly']))
            ->assertSee(route('plan.checkout', ['plan' => $plan, 'period' => 'yearly']), false);
    }

    public function test_yearly_price_defaults_to_twelve_months_when_not_set(): void
    {
        $plan = $this->plan(['price_yearly' => null]);

        $this->assertSame(708, $plan->effective_yearly_price);
        $this->assertSame(0, $plan->yearly_saving_percent);
        $this->assertSame(708, $plan->priceFor('yearly'));
        $this->assertSame(59, $plan->priceFor('monthly'));
    }

    // ------------------------------------------------------------ checkout

    public function test_checkout_page_shows_the_plan_and_both_billing_options(): void
    {
        $plan = $this->plan();

        $this->get(route('plan.checkout', $plan))
            ->assertOk()
            ->assertSee('Standard')
            ->assertSee('Nothing is charged online')
            ->assertSee('$59')
            ->assertSee('$590');
    }

    public function test_inactive_plan_cannot_be_checked_out_or_subscribed(): void
    {
        $plan = $this->plan(['is_active' => false]);

        $this->get(route('plan.checkout', $plan))->assertNotFound();
        $this->post(route('plan.subscribe', $plan), $this->checkout())->assertNotFound();
        $this->assertDatabaseCount('subscriptions', 0);
    }

    public function test_a_guest_can_subscribe_monthly(): void
    {
        $plan = $this->plan();

        $response = $this->post(route('plan.subscribe', $plan), $this->checkout());

        $subscription = Subscription::firstOrFail();
        $response->assertRedirect(route('plan.thanks', $subscription->reference));

        $this->assertMatchesRegularExpression('/^SUB-[A-Z0-9]{8}$/', $subscription->reference);
        $this->assertSame('Standard', $subscription->plan_name);
        $this->assertSame('monthly', $subscription->billing_period);
        $this->assertSame(59, $subscription->price);
        $this->assertSame(Subscription::STATUS_PENDING, $subscription->status);
        $this->assertNull($subscription->starts_at);
    }

    public function test_yearly_subscription_uses_the_yearly_price(): void
    {
        $plan = $this->plan();

        $this->post(route('plan.subscribe', $plan), $this->checkout(['billing_period' => 'yearly']));

        $this->assertSame(590, Subscription::firstOrFail()->price);
    }

    public function test_price_is_frozen_when_the_request_is_made(): void
    {
        $plan = $this->plan();
        $this->post(route('plan.subscribe', $plan), $this->checkout());

        $plan->update(['price_monthly' => 99, 'name' => 'Renamed']);

        $subscription = Subscription::firstOrFail();
        $this->assertSame(59, $subscription->price);
        $this->assertSame('Standard', $subscription->plan_name);
    }

    public function test_thanks_page_shows_the_reference_and_summary(): void
    {
        $plan = $this->plan();
        $this->post(route('plan.subscribe', $plan), $this->checkout(['phone' => '+380 67 111 22 33']));
        $subscription = Subscription::firstOrFail();

        $this->get(route('plan.thanks', $subscription->reference))
            ->assertOk()
            ->assertSee($subscription->reference)
            ->assertSee('Thank you, John')
            ->assertSee('Toyota Camry 2015')
            ->assertSee('What happens next')
            ->assertDontSee('+380 67 111 22 33');   // the customer phone number is never shown publicly
    }

    public function test_unknown_reference_returns_404(): void
    {
        $this->get(route('plan.thanks', 'SUB-NOPE0000'))->assertNotFound();
    }

    public function test_checkout_is_validated_and_keeps_input(): void
    {
        $plan = $this->plan();
        $data = $this->checkout(['name' => '', 'phone' => 'abc', 'car' => '', 'billing_period' => 'weekly']);
        unset($data['consent']);

        $this->post(route('plan.subscribe', $plan), $data)
            ->assertSessionHasErrors(['name', 'phone', 'car', 'billing_period', 'consent']);

        $this->assertDatabaseCount('subscriptions', 0);

        $this->followingRedirects()
            ->post(route('plan.subscribe', $plan), $this->checkout(['phone' => 'abc']))
            ->assertSee('Please enter a valid phone number')
            ->assertSee('John Smith');
    }

    public function test_email_and_notes_are_optional(): void
    {
        $plan = $this->plan();

        $this->post(route('plan.subscribe', $plan), $this->checkout(['email' => '', 'notes' => '']))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('subscriptions', ['name' => 'John Smith', 'email' => null, 'notes' => null]);
    }

    public function test_checkout_form_is_rate_limited(): void
    {
        $plan = $this->plan();

        for ($i = 0; $i < 10; $i++) {
            $this->post(route('plan.subscribe', $plan), $this->checkout());
        }

        $this->post(route('plan.subscribe', $plan), $this->checkout())->assertStatus(429);
    }

    // ------------------------------------------------------------ model rules

    public function test_activating_a_subscription_fills_in_the_term(): void
    {
        $plan = $this->plan();
        $this->post(route('plan.subscribe', $plan), $this->checkout(['billing_period' => 'yearly']));
        $subscription = Subscription::firstOrFail();

        $subscription->applyStatus(Subscription::STATUS_ACTIVE);

        $subscription->refresh();
        $this->assertTrue($subscription->starts_at->isToday());
        $this->assertTrue($subscription->ends_at->isSameDay(today()->addYear()));
    }

    public function test_monthly_term_lasts_one_month(): void
    {
        $subscription = Subscription::create([
            'plan_name' => 'Basic', 'billing_period' => 'monthly', 'price' => 29, 'name' => 'A B',
            'phone' => '+380950660959', 'car' => 'Car',
        ]);

        $subscription->applyStatus(Subscription::STATUS_ACTIVE, now()->setDate(2026, 1, 31)->startOfDay());

        $this->assertSame('2026-01-31', $subscription->fresh()->starts_at->toDateString());
        $this->assertSame('2026-02-28', $subscription->fresh()->ends_at->toDateString());
    }

    public function test_feature_lists_are_split_into_clean_lines(): void
    {
        $plan = $this->plan(['features' => "  One \r\n\r\nTwo\n", 'excluded_features' => null]);

        $this->assertSame(['One', 'Two'], $plan->feature_list);
        $this->assertSame([], $plan->excluded_list);
    }
}

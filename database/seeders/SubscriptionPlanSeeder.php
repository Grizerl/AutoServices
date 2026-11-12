<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

/** Default subscription plans; only runs while the table is empty. */
class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        if (SubscriptionPlan::exists()) {
            return;
        }

        $plans = [
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'Essential care for a daily driver.',
                'icon' => 'fa-snowflake',
                'price_monthly' => 29,
                'price_yearly' => 290,
                'features' => "Oil and oil filter change every 6 months\nVisual brake and suspension inspection\nFluids and tyre pressure top-up\n10% off spare parts",
                'excluded_features' => "Computer diagnostics\nPriority booking\nPick-up and delivery",
                'is_popular' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Standard',
                'slug' => 'standard',
                'description' => 'The best balance of care and price.',
                'icon' => 'fa-bolt',
                'price_monthly' => 59,
                'price_yearly' => 590,
                'features' => "Everything in Basic\nFull computer diagnostics twice a year\nBrake pads and wiper blades check\nPriority booking\n15% off spare parts",
                'excluded_features' => "Pick-up and delivery",
                'is_popular' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Complete peace of mind, door to door.',
                'icon' => 'fa-crown',
                'price_monthly' => 99,
                'price_yearly' => 990,
                'features' => "Everything in Standard\nUnlimited computer diagnostics\nPick-up and delivery of your car\nCourtesy car during repairs\nSeasonal tyre change included\n20% off spare parts",
                'excluded_features' => null,
                'is_popular' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan + ['is_active' => true]);
        }
    }
}

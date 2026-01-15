<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Starter Plan
        SubscriptionPlan::create([
            'name' => 'Starter',
            'slug' => 'starter',
            'price' => 2000,
            'billing_cycle' => 'monthly',
            'vehicle_limit' => 5,
            'user_limit' => 3,
            'features' => json_encode([
                'Fuel & Maintenance',
                'Basic Reports',
                'Limited Support',
                '✖ API Access'
            ]),
            'is_popular' => false,
            'is_active' => true,
        ]);

        // Business Plan
        SubscriptionPlan::create([
            'name' => 'Business',
            'slug' => 'business',
            'price' => 5000,
            'billing_cycle' => 'monthly',
            'vehicle_limit' => 25,
            'user_limit' => 10,
            'features' => json_encode([
                'Advanced Reports',
                'Priority Support',
                'Fuel & Maintenance',
                'API Access'
            ]),
            'is_popular' => true,
            'is_active' => true,
        ]);

        // Enterprise Plan
        SubscriptionPlan::create([
            'name' => 'Enterprise',
            'slug' => 'enterprise',
            'price' => 0, // Custom price
            'billing_cycle' => 'monthly',
            'vehicle_limit' => null, // Unlimited
            'user_limit' => null,    // Unlimited
            'features' => json_encode([
                'Unlimited Vehicles',
                'Unlimited Users',
                'API & Integrations',
                'Dedicated Account Manager'
            ]),
            'is_popular' => false,
            'is_active' => true,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $purchases = [
            [
                'user_id' => 2, // Regular user
                'product_id' => 1, // Complete Digital Marketing Masterclass
                'quantity' => 1,
                'price' => 199.99,
                'total' => 199.99,
                'status' => 'completed',
                'payment_method' => 'credit_card',
                'transaction_id' => 'txn_' . rand(100000, 999999),
                'notes' => 'First purchase from new customer',
                'paid_at' => $now->copy()->subDays(5),
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],
            [
                'user_id' => 2,
                'product_id' => 3, // React Admin Dashboard Template
                'quantity' => 1,
                'price' => 49.99,
                'total' => 49.99,
                'status' => 'completed',
                'payment_method' => 'paypal',
                'transaction_id' => 'txn_' . rand(100000, 999999),
                'notes' => 'Developer tools purchase',
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'user_id' => 2,
                'product_id' => 5, // Brand Identity Design Kit
                'quantity' => 1,
                'price' => 89.99,
                'total' => 89.99,
                'status' => 'completed',
                'payment_method' => 'stripe',
                'transaction_id' => 'txn_' . rand(100000, 999999),
                'notes' => 'Business branding package',
                'created_at' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subDays(1),
            ],
            [
                'user_id' => 2,
                'product_id' => 7, // Python Programming Bootcamp
                'quantity' => 1,
                'price' => 99.99,
                'total' => 99.99,
                'status' => 'processing',
                'payment_method' => 'credit_card',
                'transaction_id' => 'txn_' . rand(100000, 999999),
                'notes' => 'Educational content purchase',
                'created_at' => $now->copy()->subHours(2),
                'updated_at' => $now->copy()->subHours(2),
            ],
            [
                'user_id' => 2,
                'product_id' => 2, // SEO Toolkit Pro
                'quantity' => 1,
                'price' => 79.99,
                'total' => 79.99,
                'status' => 'pending',
                'payment_method' => 'bank_transfer',
                'transaction_id' => 'txn_' . rand(100000, 999999),
                'notes' => 'Marketing tools - payment pending verification',
                'created_at' => $now->copy()->subHours(1),
                'updated_at' => $now->copy()->subHours(1),
            ],
            [
                'user_id' => 2,
                'product_id' => 10, // Task Management Mobile App
                'quantity' => 1,
                'price' => 299.99,
                'total' => 299.99,
                'status' => 'refunded',
                'payment_method' => 'credit_card',
                'transaction_id' => 'txn_' . rand(100000, 999999),
                'notes' => 'Software purchase - refunded per customer request',
                'created_at' => $now->copy()->subDays(7),
                'updated_at' => $now->copy()->subDays(6),
            ],
            [
                'user_id' => 2,
                'product_id' => 4, // Laravel E-commerce Package
                'quantity' => 1,
                'price' => 149.99,
                'total' => 149.99,
                'status' => 'shipped',
                'payment_method' => 'paypal',
                'transaction_id' => 'txn_' . rand(100000, 999999),
                'notes' => 'Development tools - delivered via email',
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'user_id' => 2,
                'product_id' => 6, // Social Media Post Templates
                'quantity' => 2,
                'price' => 39.99,
                'total' => 79.98,
                'status' => 'completed',
                'payment_method' => 'stripe',
                'transaction_id' => 'txn_' . rand(100000, 999999),
                'notes' => 'Bulk purchase - 2 licenses',
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
            ],
        ];

        foreach ($purchases as $purchase) {
            DB::table('product_purchases')->insert($purchase);
        }

        $this->command->info('PurchaseSeeder completed successfully!');
        $this->command->info('Created ' . count($purchases) . ' sample purchases.');
    }
}

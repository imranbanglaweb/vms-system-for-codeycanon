<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'ABC Transport Services',
                'contact_person' => 'John Smith',
                'contact_number' => '+1-555-0101',
                'email' => 'john@abctransport.com',
                'address' => '123 Main Street',
                'city' => 'New York',
                'country' => 'USA',
                'status' => 1,
            ],
            [
                'name' => 'XYZ Fleet Management',
                'contact_person' => 'Jane Doe',
                'contact_number' => '+1-555-0102',
                'email' => 'jane@xyzfleet.com',
                'address' => '456 Oak Avenue',
                'city' => 'Los Angeles',
                'country' => 'USA',
                'status' => 1,
            ],
            [
                'name' => 'Global Vehicle Rentals',
                'contact_person' => 'Mike Johnson',
                'contact_number' => '+1-555-0103',
                'email' => 'mike@globalrentals.com',
                'address' => '789 Pine Road',
                'city' => 'Chicago',
                'country' => 'USA',
                'status' => 1,
            ],
            [
                'name' => 'Premium Auto Leasing',
                'contact_person' => 'Sarah Williams',
                'contact_number' => '+1-555-0104',
                'email' => 'sarah@premiumauto.com',
                'address' => '321 Elm Street',
                'city' => 'Houston',
                'country' => 'USA',
                'status' => 1,
            ],
            [
                'name' => 'City Cab Services',
                'contact_person' => 'David Brown',
                'contact_number' => '+1-555-0105',
                'email' => 'david@citycab.com',
                'address' => '654 Maple Drive',
                'city' => 'Phoenix',
                'country' => 'USA',
                'status' => 1,
            ],
        ];

        foreach ($vendors as $vendor) {
            Vendor::create($vendor);
        }
    }
}

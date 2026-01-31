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
                'name' => 'ABC Transport Services Ltd.',
                'contact_person' => 'Mohammad Ali Khan',
                'contact_number' => '+880-1711-000001',
                'email' => 'ali@abctransport.com',
                'address' => '123 Transport Avenue, Gulshan',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'XYZ Fleet Management',
                'contact_person' => 'Rahima Begum',
                'contact_number' => '+880-1711-000002',
                'email' => 'rahima@xyzfleet.com',
                'address' => '456 Corporate Road, Banani',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'Global Vehicle Rentals',
                'contact_person' => 'John Smith',
                'contact_number' => '+880-1711-000003',
                'email' => 'john@globalrentals.com',
                'address' => '789 Rental Plaza, Motijheel',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'Premium Auto Leasing Co.',
                'contact_person' => 'Sarah Williams',
                'contact_number' => '+880-1711-000004',
                'email' => 'sarah@premiumauto.com',
                'address' => '321 Luxury Lane, Dhanmondi',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'City Cab Services',
                'contact_person' => 'David Brown',
                'contact_number' => '+880-1711-000005',
                'email' => 'david@citycab.com',
                'address' => '654 Taxi Stand, Uttara',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'Rapid Ride Solutions',
                'contact_person' => 'Fatima Akter',
                'contact_number' => '+880-1711-000006',
                'email' => 'fatima@rapidride.com',
                'address' => '987 Fast Drive, Mirpur',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'Elite Transportation',
                'contact_person' => 'Michael Chen',
                'contact_number' => '+880-1711-000007',
                'email' => 'michael@elitetransport.com',
                'address' => '147 Executive Boulevard, Baridhara',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'Safe Journey Logistics',
                'contact_person' => 'Ayesha Siddiqua',
                'contact_number' => '+880-1711-000008',
                'email' => 'ayesha@safejourney.com',
                'address' => '258 Security Road, Khilgaon',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'Comfort Car Rentals',
                'contact_person' => 'Robert Garcia',
                'contact_number' => '+880-1711-000009',
                'email' => 'robert@comfortcarrentals.com',
                'address' => '369 Comfort Street, Badda',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'Metro Fleet Services',
                'contact_person' => 'Nasreen Jahan',
                'contact_number' => '+880-1711-000010',
                'email' => 'nasreen@metrofleet.com',
                'address' => '741 Metro Junction, Gazipur',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'status' => 1,
            ],
        ];

        foreach ($vendors as $vendor) {
            Vendor::updateOrCreate(
                ['name' => $vendor['name']],
                [
                    'contact_person' => $vendor['contact_person'],
                    'contact_number' => $vendor['contact_number'],
                    'email' => $vendor['email'],
                    'address' => $vendor['address'],
                    'city' => $vendor['city'],
                    'country' => $vendor['country'],
                    'status' => $vendor['status'],
                    'created_by' => 1,
                ]
            );
        }

        $this->command->info('Vendor seeder completed with 10 vendors.');
    }
}

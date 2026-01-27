<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $drivers = [
            [
                'driver_name' => 'Demo Driver',
                'mobile' => '01700000000',
                'license_number' => 'DL-001-2024',
                'nid' => '1234567890123',
            ],
            [
                'driver_name' => 'Karim Ahmed',
                'mobile' => '01700000001',
                'license_number' => 'DL-002-2024',
                'nid' => '1234567890124',
            ],
            [
                'driver_name' => 'Rahim Uddin',
                'mobile' => '01700000002',
                'license_number' => 'DL-003-2024',
                'nid' => '1234567890125',
            ],
            [
                'driver_name' => 'Jamal Hossain',
                'mobile' => '01700000003',
                'license_number' => 'DL-004-2024',
                'nid' => '1234567890126',
            ],
            [
                'driver_name' => 'Salam Khan',
                'mobile' => '01700000004',
                'license_number' => 'DL-005-2024',
                'nid' => '1234567890127',
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::updateOrCreate(
                ['license_number' => $driver['license_number']],
                [
                    'driver_name' => $driver['driver_name'],
                    'mobile' => $driver['mobile'],
                    'nid' => $driver['nid'],
                    'status' => 1,
                    'created_by' => 1,
                ]
            );
        }
    }
}

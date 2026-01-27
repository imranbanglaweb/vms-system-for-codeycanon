<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $vehicles = [
            [
                'vehicle_number' => 'DHA-1234',
                'vehicle_name' => 'Toyota Corolla',
                'vehicle_type_id' => 1,
                'seat_capacity' => 4,
                'ownership' => 'Owned',
            ],
            [
                'vehicle_number' => 'DHA-5678',
                'vehicle_name' => 'Toyota Hiace',
                'vehicle_type_id' => 2,
                'seat_capacity' => 12,
                'ownership' => 'Owned',
            ],
            [
                'vehicle_number' => 'DHA-9012',
                'vehicle_name' => 'Hino Bus',
                'vehicle_type_id' => 3,
                'seat_capacity' => 40,
                'ownership' => 'Owned',
            ],
            [
                'vehicle_number' => 'DHA-3456',
                'vehicle_name' => 'Mitsubishi Pickup',
                'vehicle_type_id' => 4,
                'seat_capacity' => 2,
                'ownership' => 'Rented',
            ],
            [
                'vehicle_number' => 'DHA-7890',
                'vehicle_name' => 'Honda Civic',
                'vehicle_type_id' => 1,
                'seat_capacity' => 4,
                'ownership' => 'Leased',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::updateOrCreate(
                ['vehicle_number' => $vehicle['vehicle_number']],
                [
                    'vehicle_name' => $vehicle['vehicle_name'],
                    'vehicle_type_id' => $vehicle['vehicle_type_id'],
                    'seat_capacity' => $vehicle['seat_capacity'],
                    'ownership' => $vehicle['ownership'],
                    'status' => 1,
                ]
            );
        }
    }
}

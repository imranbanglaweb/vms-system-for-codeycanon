<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Car', 'status' => 1],
            ['name' => 'Microbus', 'status' => 1],
            ['name' => 'Bus', 'status' => 1],
            ['name' => 'Pickup', 'status' => 1],
            ['name' => 'Truck', 'status' => 1],
            ['name' => 'Van', 'status' => 1],
            ['name' => 'SUV', 'status' => 1],
            ['name' => 'Motorcycle', 'status' => 1],
        ];

        foreach ($types as $type) {
            VehicleType::updateOrCreate(
                ['name' => $type['name']],
                ['status' => $type['status']]
            );
        }
    }
}

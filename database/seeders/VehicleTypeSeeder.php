<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    public function run()
    {
        $types = ['Car', 'Microbus', 'Bus', 'Pickup'];

        foreach ($types as $type) {
            VehicleType::create([
                'name' => $type,
                'status' => 1
            ]);
        }
    }
}

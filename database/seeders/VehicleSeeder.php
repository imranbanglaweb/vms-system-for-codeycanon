<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        Vehicle::create([
            'vehicle_number' => 'DHA-1234',
            'vehicle_type_id' => 1,
            'status' => 1,
        ]);
    }
}

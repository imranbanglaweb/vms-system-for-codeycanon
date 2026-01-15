<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    public function run()
    {
        Driver::create([
            'driver_name' => 'Demo Driver',
            'mobile' => '01700000000',
            'status' => 1,
              'created_by' => 1, 
        ]);
    }
}

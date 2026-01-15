<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $locations = ['Headquarters', 'Branch Office', 'Warehouse'];

        foreach ($locations as $loc) {
            Location::firstOrCreate(
                ['location_name' => $loc],
                [
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1
                ]
            );
        }
    }
}

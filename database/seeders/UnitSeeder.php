<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\Location;

class UnitSeeder extends Seeder
{
    public function run()
    {
        // Make sure a location exists
        $location = Location::first();
        if (!$location) {
            // If no location exists, create a default one
            $location = Location::create([
                'location_name' => 'Headquarters',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }

        $units = ['Head Office', 'Factory', 'Branch Office'];

        foreach ($units as $unit) {
            Unit::firstOrCreate(
                ['unit_name' => $unit], // search by unit_name
                [
                    'location_id' => $location->id, // required
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1
                ]
            );
        }
    }
}

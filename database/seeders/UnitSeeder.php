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

        $units = [
            ['unit_name' => 'Head Office', 'unit_code' => 'HO'],
            ['unit_name' => 'Factory', 'unit_code' => 'FAC'],
            ['unit_name' => 'Branch Office', 'unit_code' => 'BO'],
            ['unit_name' => 'Warehouse Unit', 'unit_code' => 'WH'],
            ['unit_name' => 'Distribution Unit', 'unit_code' => 'DU'],
            ['unit_name' => 'Regional Unit', 'unit_code' => 'RU'],
        ];

        foreach ($units as $unit) {
            Unit::updateOrCreate(
                ['unit_name' => $unit['unit_name']],
                [
                    'unit_code' => $unit['unit_code'] ?? null,
                    'location_id' => $location->id,
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Requisition;
use Faker\Factory as Faker;

class RequisitionSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        Requisition::create([
            'requested_by' => 1,
            'department_id' => 1,
            'unit_id' => 1,
            'vehicle_type' => 1,
            'requisition_number' => 'REQ-00001',
            'from_location' => 'Head Office',
            'to_location' => 'Factory',
            'requisition_date' => now(),
            'travel_date' => now()->addDay(),
            'number_of_passenger' => 2,
            'purpose' => 'Official Visit',
            'status' => 1,
            'created_by' => 1,
        ]);

        // Generate 100 dummy requisitions
        for ($i = 0; $i < 100; $i++) {
            Requisition::create([
                'requested_by' => 1,
                'department_id' => $faker->numberBetween(1, 10),
                'unit_id' => $faker->numberBetween(1, 6),
                'vehicle_type' => $faker->numberBetween(1, 8),
                'requisition_number' => $faker->unique()->bothify('REQ-#####'),
                'from_location' => $faker->city,
                'to_location' => $faker->city,
                'requisition_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'travel_date' => $faker->dateTimeBetween('now', '+1 month'),
                'number_of_passenger' => $faker->numberBetween(1, 5),
                'purpose' => $faker->sentence,
                'status' => $faker->numberBetween(1, 3),
                'created_by' => 1,
            ]);
        }
    }
}

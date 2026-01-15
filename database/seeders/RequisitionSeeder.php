<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Requisition;

class RequisitionSeeder extends Seeder
{
    public function run()
    {
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
    }
}

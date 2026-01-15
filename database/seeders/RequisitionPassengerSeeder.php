<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RequisitionPassenger;

class RequisitionPassengerSeeder extends Seeder
{
    public function run()
    {
        RequisitionPassenger::create([
            'requisition_id' => 1,
            'employee_id' => 1,
            'created_by' => 1,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        Employee::create([
            'name' => 'Demo Employee',
            'email' => 'employee@demo.com',
            'department_id' => 1,
            'unit_id' => 1,
            'designation' => 'Officer',
        ]);
    }
}

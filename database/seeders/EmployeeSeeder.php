<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employees = [
            [
                'name' => 'Demo Employee',
                'email' => 'employee@demo.com',
                'department_id' => 1,
                'unit_id' => 1,
                'designation' => 'Officer',
                'phone' => '01800000001',
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@demo.com',
                'department_id' => 2,
                'unit_id' => 1,
                'designation' => 'Manager',
                'phone' => '01800000002',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@demo.com',
                'department_id' => 3,
                'unit_id' => 1,
                'designation' => 'Accountant',
                'phone' => '01800000003',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@demo.com',
                'department_id' => 4,
                'unit_id' => 1,
                'designation' => 'Supervisor',
                'phone' => '01800000004',
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah.williams@demo.com',
                'department_id' => 1,
                'unit_id' => 1,
                'designation' => 'HR Executive',
                'phone' => '01800000005',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::updateOrCreate(
                ['email' => $employee['email']],
                [
                    'name' => $employee['name'],
                    'department_id' => $employee['department_id'],
                    'unit_id' => $employee['unit_id'],
                    'designation' => $employee['designation'],
                    'phone' => $employee['phone'] ?? null,
                ]
            );
        }
    }
}

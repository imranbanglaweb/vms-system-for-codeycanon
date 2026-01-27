<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['department_name' => 'HR', 'department_code' => 'HR'],
            ['department_name' => 'IT', 'department_code' => 'IT'],
            ['department_name' => 'Accounts', 'department_code' => 'ACC'],
            ['department_name' => 'Operations', 'department_code' => 'OPS'],
            ['department_name' => 'Finance', 'department_code' => 'FIN'],
            ['department_name' => 'Marketing', 'department_code' => 'MKT'],
            ['department_name' => 'Sales', 'department_code' => 'SLS'],
            ['department_name' => 'Administration', 'department_code' => 'ADM'],
            ['department_name' => 'Transport', 'department_code' => 'TRN'],
            ['department_name' => 'Logistics', 'department_code' => 'LOG'],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(
                ['department_name' => $dept['department_name']],
                [
                    'department_code' => $dept['department_code'],
                    'status' => 1,
                    'unit_id' => 1,
                    'created_by' => 1,
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = ['HR', 'IT', 'Accounts', 'Operations'];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['department_name' => $dept], // search by this
                [
                    'department_code' => $dept, // set if not exists
                    'status' => 1,
                    'unit_id' => 1,
                      'created_by' => 1, 
                ]
            );
        }
    }
}

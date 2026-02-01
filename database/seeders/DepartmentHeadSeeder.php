<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Employee;

class DepartmentHeadSeeder extends Seeder
{
    public function run()
    {
        // Department head assignments
        $departmentHeads = [
            'HR' => ['name' => 'Demo Employee', 'email' => 'employee@demo.com'],
            'IT' => ['name' => 'John Doe', 'email' => 'john.doe@demo.com'],
            'Accounts' => ['name' => 'Jane Smith', 'email' => 'jane.smith@demo.com'],
            'Operations' => ['name' => 'Mike Johnson', 'email' => 'mike.johnson@demo.com'],
            'Finance' => ['name' => 'Sarah Williams', 'email' => 'sarah.williams@demo.com'],
        ];

        foreach ($departmentHeads as $deptName => $headInfo) {
            $department = Department::where('department_name', $deptName)->first();
            
            if ($department) {
                $head = Employee::where('email', $headInfo['email'])->first();
                
                if ($head) {
                    $department->update([
                        'head_employee_id' => $head->id,
                        'head_name' => $head->name,
                        'head_email' => $head->email,
                        'updated_by' => 1,
                    ]);
                    
                    $this->command->info("Assigned {$headInfo['name']} as head of {$deptName}");
                } else {
                    $this->command->warn("Employee {$headInfo['email']} not found for {$deptName}");
                }
            } else {
                $this->command->warn("Department {$deptName} not found");
            }
        }

        // Leave these departments without heads: Marketing, Sales, Administration, Transport, Logistics
        $this->command->info('Department heads assigned successfully!');
    }
}

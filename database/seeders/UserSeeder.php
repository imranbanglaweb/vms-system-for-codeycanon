<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Location;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ================= ROLES =================
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $adminRole = Role::where('name', 'Admin')->first();
        $deptHeadRole   = Role::where('name', 'Department Head')->first();
        $transportRole  = Role::where('name', 'Transport')->first();
        $employeeRole   = Role::where('name', 'Employee')->first();

        // Get first records for linking
        $firstEmployee = Employee::first();
        $firstDepartment = Department::first();
        $firstUnit = Unit::first();
        $firstLocation = Location::first();

        $dummyImage = 'default.png';

        // ================= SUPER ADMIN =================
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@demo.com'],
            [
                'name' => 'Super Admin',
                'user_name' => 'SA001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'super_user',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000001',
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // ================= ADMIN =================
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'System Admin',
                'user_name' => 'AD001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'admin',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000002',
            ]
        );
        $admin->assignRole($adminRole);

        // ================= TRANSPORT MANAGER =================
        $transport = User::firstOrCreate(
            ['email' => 'transport@demo.com'],
            [
                'name' => 'Transport Manager',
                'user_name' => 'TM001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'super_user',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000004',
            ]
        );
        $transport->assignRole($transportRole);

        // ================= EMPLOYEE USERS (Linked to Employees) =================
        
        // Get all employees with their emails
        $employees = Employee::whereIn('email', [
            'employee@demo.com',
            'john.doe@demo.com',
            'jane.smith@demo.com',
            'mike.johnson@demo.com',
            'sarah.williams@demo.com',
            'alex.brown@demo.com',
        ])->get();

        foreach ($employees as $emp) {
            // Create or update user for each employee
            $user = User::firstOrCreate(
                ['email' => $emp->email],
                [
                    'name' => $emp->name,
                    'user_name' => $emp->employee_code,
                    'password' => Hash::make('password'),
                    'status' => 1,
                    'user_type' => 'normal_user',
                    'employee_id' => $emp->id,
                    'company_id' => 1,
                    'department_id' => $emp->department_id,
                    'unit_id' => $emp->unit_id,
                    'location_id' => $emp->location_id,
                    'user_image' => $dummyImage,
                    'cell_phone' => $emp->phone ?? '01700000000',
                ]
            );
            
            // Assign employee role
            $user->syncRoles([$employeeRole]);
            
            $this->command->info("Created user for employee: {$emp->name} ({$emp->email})");
        }

        // ================= DEPARTMENT HEAD USERS =================
        
        // Create department head users based on assigned heads
        $departmentHeads = [
            'HR' => 'Demo Employee',
            'IT' => 'John Doe',
            'Accounts' => 'Jane Smith',
            'Operations' => 'Mike Johnson',
            'Finance' => 'Sarah Williams',
        ];

        foreach ($departmentHeads as $deptName => $empName) {
            $department = Department::where('department_name', $deptName)->first();
            if ($department && $department->headEmployee) {
                $headEmployee = $department->headEmployee;
                
                // Create or update user as department head
                $headUser = User::firstOrCreate(
                    ['email' => $headEmployee->email],
                    [
                        'name' => $headEmployee->name,
                        'user_name' => $headEmployee->employee_code,
                        'password' => Hash::make('password'),
                        'status' => 1,
                        'user_type' => 'department_head',
                        'employee_id' => $headEmployee->id,
                        'company_id' => 1,
                        'department_id' => $department->id,
                        'unit_id' => $headEmployee->unit_id,
                        'location_id' => $headEmployee->location_id,
                        'user_image' => $dummyImage,
                        'cell_phone' => $headEmployee->phone ?? '01700000000',
                    ]
                );
                
                // Assign department head role
                $headUser->syncRoles([$deptHeadRole, $employeeRole]);
                
                $this->command->info("Created department head user: {$headEmployee->name} for {$deptName}");
            }
        }

        // ================= SUMMARY =================
        $this->command->info('User seeding completed!');
        $this->command->info('Users created: Super Admin, Admin, Transport Manager, and all department head employees');
    }
}

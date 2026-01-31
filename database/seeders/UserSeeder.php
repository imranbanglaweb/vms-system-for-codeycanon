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

        // Get first employee for linking
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

        // ================= DEPARTMENT HEAD =================
        $deptHead = User::firstOrCreate(
            ['email' => 'depthead@demo.com'],
            [
                'name' => 'Department Head',
                'user_name' => 'DH001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'department_head',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000003',
            ]
        );
        $deptHead->syncRoles([$deptHeadRole]);

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

        // ================= EMPLOYEE =================
        $employee = User::firstOrCreate(
            ['email' => 'employee@demo.com'],
            [
                'name' => 'Employee User',
                'user_name' => 'EMP001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'normal_user',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000005',
            ]
        );
        $employee->assignRole($employeeRole);

        // ================= ADDITIONAL USERS =================
        
        // HR Manager
        $hrManager = User::firstOrCreate(
            ['email' => 'hrmanager@demo.com'],
            [
                'name' => 'HR Manager',
                'user_name' => 'HR001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'admin',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000006',
            ]
        );
        $hrManager->assignRole($adminRole);

        // Finance Manager
        $financeManager = User::firstOrCreate(
            ['email' => 'financemanager@demo.com'],
            [
                'name' => 'Finance Manager',
                'user_name' => 'FM001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'admin',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000007',
            ]
        );
        $financeManager->assignRole($adminRole);
    }
}

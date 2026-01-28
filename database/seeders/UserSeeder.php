<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ================= ROLES =================
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $deptHeadRole   = Role::where('name', 'Department Head')->first();
        $transportRole  = Role::where('name', 'Transport')->first();
        $employeeRole   = Role::where('name', 'Employee')->first();

        // ================= SUPER ADMIN =================
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@demo.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'status' => 1,
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // ================= DEPARTMENT HEAD =================
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Department Head',
                'password' => Hash::make('password'),
                'status' => 1,
                'department_id' => 1, // Assuming HR department from DepartmentSeeder
                'user_type' => 'department_head',
            ]
        );
        $admin->syncRoles([$deptHeadRole]);

        // ================= TRANSPORT =================
        $transport = User::firstOrCreate(
            ['email' => 'transport@demo.com'],
            [
                'name' => 'Transport Manager',
                'password' => Hash::make('password'),
                'status' => 1,
            ]
        );
        $transport->assignRole($transportRole);

        // ================= EMPLOYEE =================
        $employee = User::firstOrCreate(
            ['email' => 'employee@demo.com'],
            [
                'name' => 'Employee User',
                'password' => Hash::make('password'),
                'status' => 1,
            ]
        );
        $employee->assignRole($employeeRole);
    }
}

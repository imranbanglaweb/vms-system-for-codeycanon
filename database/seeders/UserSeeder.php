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
        $adminRole      = Role::where('name', 'Admin')->first();
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

        // ================= ADMIN =================
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'status' => 1,
            ]
        );
        $admin->assignRole($adminRole);

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

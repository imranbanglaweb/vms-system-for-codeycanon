<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Super Admin role with ALL permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        
        // Get all permissions and assign to Super Admin
        $allPermissions = Permission::all();
        if ($allPermissions->isNotEmpty()) {
            $superAdminRole->syncPermissions($allPermissions);
        }

        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Transport']);
        Role::firstOrCreate(['name' => 'Employee']);
        Role::firstOrCreate(['name' => 'Department Head']);
        Role::firstOrCreate(['name' => 'Manager']);
    }
} 
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ================= ROLES =================
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $admin      = Role::where('name', 'Admin')->first();
        $transport  = Role::where('name', 'Transport')->first();
        $employee   = Role::where('name', 'Employee')->first();

        // ================= SUPER ADMIN =================
        // Super Admin gets EVERYTHING
        $superAdmin->syncPermissions(Permission::all());

        // ================= ADMIN =================
        $adminPermissions = [
            'dashboard',

            // Requisitions
            'requisition.create',
            'requisition.view',
            'requisition.approve',
            'requisition.export',

            // Vehicle
            'vehicle.manage',
            'vehicle.create',
            'vehicle.edit',
            'vehicle.delete',

            // Driver
            'driver.manage',
            'driver.create',
            'driver.edit',
            'driver.delete',

            // Employee
            'employee.manage',
            'employee.create',
            'employee.edit',
            'employee.delete',

            // Department / Unit
            'department.manage',
            'department.create',
            'department.edit',
            'unit.manage',

            // Maintenance
            'maintenance.manage',
            'maintenance.create',
            'maintenance.edit',
            'maintenance.approve',

            // Reports
            'report.requisition',
            'report.maintenance',
            'report.export',

            // Users / Roles
            'user.manage',
            'role-manage',
            'permission.manage',

            // Menu & Settings
            'menu.manage',
            'settings.manage',
            'translation.manage',
        ];

        $admin->syncPermissions($adminPermissions);

        // ================= TRANSPORT =================
        $transportPermissions = [
            'dashboard',

            // Requisitions
            'requisition.view',
            'requisition.assign',

            // Trips / Transport
            'trip.manage',
            'trip.start',
            'trip.finish',

            // Vehicle & Driver
            'vehicle.manage',
            'driver.manage',

            // Maintenance
            'maintenance.view',
            'maintenance.create',

            // Reports
            'report.trip.fuel',
            'report.vehicle.utilization',
        ];

        $transport->syncPermissions($transportPermissions);

        // ================= EMPLOYEE =================
        $employeePermissions = [
            'dashboard',

            // Requisitions
            'requisition.create',
            'requisition.view',

            // Documents
            'document.manage',

            // Notifications
            'notification.view',
        ];

        $employee->syncPermissions($employeePermissions);
    }
}

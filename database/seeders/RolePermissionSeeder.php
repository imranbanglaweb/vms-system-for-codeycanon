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
        $deptHead   = Role::where('name', 'Department Head')->first();

        // ================= SUPER ADMIN =================
        $superAdmin?->syncPermissions(Permission::all());

        // ================= ADMIN =================
        $adminPermissions = [

            'dashboard',

            // Requisitions
            'requisition-create',
            'requisition-view',
            'requisition-edit',
            'requisition-delete',
            'requisition-export',
            'requisition-download',

            // Department Approval
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',

            // Transport Approval
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'transport-approval-reject',

            // Trip Sheets
            'trip-manage',
            'trip-sheet-view',
            'trip-start',
            'trip-finish',
            'trip-end',

            // Vehicles
            'vehicle-manage',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',

            // Drivers
            'driver-manage',
            'driver-create',
            'driver-edit',
            'driver-delete',

            // Employees
            'employee-manage',
            'employee-create',
            'employee-edit',
            'employee-delete',

            // Department / Unit
            'department-manage',
            'department-create',
            'department-edit',
            'unit-manage',

            // Company
            'company-manage',

            // Maintenance
            'maintenance-manage',
            'maintenance-create',
            'maintenance-edit',
            'maintenance-approve',

            // Reports
            'report-requisition',
            'report-maintenance',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-export',

            // Settings & Notifications
            'settings-notification',
            'notification-manage',

            // Users / Roles
            'user-manage',
            'role-manage',
            'permission-manage',

            // Menu & Settings
            'menu-manage',
            'settings-manage',
            'translation-manage',
        ];

        $admin?->syncPermissions($adminPermissions);

        // ================= TRANSPORT =================
        $transportPermissions = [

            'dashboard',

            // Requisition View Only
            'requisition-view',

            // Transport Approval Stage
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'transport-approval-reject',

            // Trips / Trip Sheets
            'trip-manage',
            'trip-sheet-view',
            'trip-start',
            'trip-finish',
            'trip-end',

            // Vehicle & Driver View/Manage
            'vehicle-manage',
            'driver-manage',

            // Maintenance
            'maintenance-view',
            'maintenance-create',

            // Reports
            'report-trip-fuel',
            'report-vehicle-utilization',
        ];

        $transport?->syncPermissions($transportPermissions);

        // ================= EMPLOYEE =================
        $employeePermissions = [

            'dashboard',

            // Requisitions
            'requisition-create',
            'requisition-view',

            // Documents
            'document-manage',

            // Notifications
            'notification-view',
        ];

        $employee?->syncPermissions($employeePermissions);

        // ================= DEPARTMENT HEAD =================
        $deptHeadPermissions = [
            'dashboard',
            'requisition-view',
            'requisition-create',
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',
        ];

        $deptHead?->syncPermissions($deptHeadPermissions);
    }
}

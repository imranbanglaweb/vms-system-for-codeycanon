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
        $manager    = Role::where('name', 'Manager')->first();
        $driver     = Role::where('name', 'Driver')->first();

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
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',

            // Vehicles
            'vehicle-manage',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',
            'vehicle-view',
            'vehicle-export',
            'vehicle-type-manage',

            // Drivers
            'driver-manage',
            'driver-create',
            'driver-edit',
            'driver-delete',
            'driver-view',
            'driver-export',
            'license-type-manage',
            
            // Driver Documents
            'driver-document-manage',
            'driver-document-upload',
            'driver-document-view',
            'driver-document-delete',
            'driver-document-approve',
            
            // Driver Schedule
            'driver-schedule-manage',
            'driver-schedule-view',
            'driver-schedule-assign',
            'driver-schedule-edit',
            
            // Driver Performance
            'driver-performance-manage',
            'driver-performance-view',
            'driver-performance-report',
            
            // Driver Availability
            'driver-availability-manage',
            'driver-availability-view',
            'driver-availability-update',

            // Employees
            'employee-manage',
            'employee-create',
            'employee-edit',
            'employee-delete',
            'employee-import',
            'employee-export',

            // Department / Unit
            'department-manage',
            'department-create',
            'department-edit',
            'unit-manage',

            // Location
            'location-manage',

            // Company
            'company-manage',

            // Maintenance
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'maintenance-edit',
            'maintenance-approve',
            'maintenance-history',
            'maintenance-type-manage',
            'maintenance-vendor-manage',
            'maintenance-category-manage',

            // Reports
            'report-requisition',
            'report-maintenance',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-export',

            // Settings & Notifications
            'settings-notification',
            'settings-manage',
            'settings-language',
            'notification-manage',
            'notification-view',

            // Users / Roles
            'user-manage',
            'user-create',
            'user-edit',
            'user-delete',
            'role-manage',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-manage',
            'permission-create',
            'permission-edit',
            'permission-delete',

            // Menu & Settings
            'menu-manage',
            'menu-create',
            'menu-edit',
            'menu-delete',
            'menu-list',
            'menu-reorder',
            'translation-manage',
            'translation-create',
            'translation-update',
            'translation-auto',
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
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-export',

            // Vehicle & Driver View/Manage
            'vehicle-manage',
            'vehicle-view',
            'driver-manage',
            'driver-view',
            
            // Driver Schedule
            'driver-schedule-manage',
            'driver-schedule-view',
            'driver-schedule-assign',
            
            // Driver Availability
            'driver-availability-manage',
            'driver-availability-view',
            'driver-availability-update',

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

        // ================= MANAGER =================
        $managerPermissions = [
            'dashboard',
            
            // Requisitions
            'requisition-view',
            'requisition-create',
            
            // Department Approval
            'department-approval-view',
            'department-approval-approve',
            
            // Transport Approval
            'transport-approval-view',
            
            // Trip Sheets
            'trip-sheet-view',
            'trip-manage',
            
            // Driver Performance
            'driver-view',
            'driver-performance-view',
            'driver-performance-report',
            
            // Vehicles
            'vehicle-view',
            
            // Reports
            'report-requisition',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
        ];

        $manager?->syncPermissions($managerPermissions);

        // ================= DRIVER =================
        $driverPermissions = [
            'dashboard',
            
            // View own schedule
            'driver-schedule-view',
            'driver-availability-view',
            
            // Trip management
            'trip-sheet-view',
            
            // Notifications
            'notification-view',
        ];

        $driver?->syncPermissions($driverPermissions);

        $this->command->info('RolePermissionSeeder completed successfully!');
    }
}

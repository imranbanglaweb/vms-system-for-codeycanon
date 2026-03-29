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
            'maintenance-approval-view',
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

            // Fuel Management
            'fuel-manage',
            'fuel-log-entry',
            'fuel-history-view',

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
            'maintenance-approval-view',

            // Reports
            'report-trip-fuel',
            'report-vehicle-utilization',
        ];

        $transport?->syncPermissions($transportPermissions);

        // ================= EMPLOYEE =================
        $employeePermissions = [

            'dashboard',

            // Requisitions - Create, View, Edit (No Delete)
            'requisition-create',
            'requisition-view',
            'requisition-edit',
            'requisition-pending-view',
            'requisition-approved-view',

            // Driver - List View Only
            'driver-list-view',

            // Vehicle - List View Only
            'vehicle-list-view',

            // Maintenance - Create and View Own
            'maintenance-create',
            'maintenance-view',

            // Reports - Own Requisitions Only
            'report-requisition-own',
            'report-maintenance-own',

            // Employee - View and Edit Own Profile
            'employee-view-own',
            'employee-edit-own',

            // Documents
            'document-manage',
            'document-create',
            'document-view',
            'document-history',

            // Notifications
            'notification-view',

            // Support / Helpdesk
            'support-create',
            'support-edit',

            // Profile & Settings
            'profile-view',
            'profile-edit',

            // Employee self-service
            'my-requisitions',
            'my-documents',
        ];

        $employee?->syncPermissions($employeePermissions);

        // ================= DEPARTMENT HEAD =================
        $deptHeadPermissions = [
            'dashboard',
            
            // Requisitions
            'requisition-view',
            'requisition-create',
            
            // Department Approval
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',
            'requisition-approval-department',
            
            // Transport Approval
            'transport-approval-view',
            
            // Employee Management (Department specific)
            'employee-list-department',
            'employee-create-department',
            'employee-edit-department',
            'employee-delete-department',
            'employee-view-own',
            'employee-edit-own',
            
            // Vehicle (View for department)
            'vehicle-list-department',
            'vehicle-view',
            
            // Driver (View for department)
            'driver-list-department',
            'driver-view',
            
            // Maintenance
            'maintenance-view',
            'maintenance-create',
            'maintenance-approval-view',
            'maintenance-approval-department',
            
            // Reports (Department specific)
            'report-requisition-department',
            'report-maintenance-department',
            
            // Profile
            'profile-view',
            'profile-edit',
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
            
            // Maintenance
            'maintenance-view',
            'maintenance-create',
            'maintenance-approval-view',
            
            // Reports
            'report-requisition',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',

            // Fuel Management
            'fuel-manage',
            'fuel-history-view',
        ];

        $manager?->syncPermissions($managerPermissions);

        // ================= DRIVER =================
        $driverPermissions = [
            'dashboard',
            
            // Driver Access - Required for driver personal module menus
            'driver-access',
            
            // Driver Schedule
            'driver-schedule-view',
            'driver-schedule-own',
            'driver-availability-view',
            'driver-availability-update',
            
            // Trip Sheets - Own trips only
            'trip-sheet-view',
            'trip-sheet-own',
            'trip-start',
            'trip-finish',
            'trip-end',
            
            // Fuel & Expense Logging
            'trip-fuel-log',
            'trip-fuel-own',
            
            // Driver Documents - View own documents
            'driver-document-view',
            
            // Driver Vehicle - View assigned vehicle
            'driver-vehicle',
            
            // Notifications
            'notification-view',
            
            // Profile & Employee - View and edit own profile
            'profile-view',
            'profile-edit',
            'employee-view-own',
            'employee-edit-own',
        ];

        $driver?->syncPermissions($driverPermissions);

        $this->command->info('RolePermissionSeeder completed successfully!');
    }
}

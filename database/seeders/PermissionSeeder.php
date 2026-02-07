<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [

            // ================= DASHBOARD =================
            'dashboard',

            // ================= MENU =================
            'menu-manage',
            'menu-create',
            'menu-edit',
            'menu-delete',
            'menu-reorder',
            'menu-list',

            // ================= REQUISITIONS =================
            'requisition-create',
            'requisition-view',
            'requisition-edit',
            'requisition-delete',
            'requisition-export',
            'requisition-download',
            'requisition-approve',
            'requisition-pending-view',
            'requisition-approved-view',

            // ================= DEPARTMENT APPROVAL WORKFLOW =================
            'department-approve',
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',

            // ================= TRANSPORT APPROVAL WORKFLOW =================
            'transport-approve',
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'transport-approval-reject',

            // ================= VEHICLE MANAGEMENT =================
            'vehicle-manage',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',
            'vehicle-type-manage',
            'vehicle-view',
            'vehicle-export',

            // ================= DRIVER MANAGEMENT =================
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

            // ================= EMPLOYEE MANAGEMENT =================
            'employee-manage',
            'employee-create',
            'employee-edit',
            'employee-delete',
            'employee-import',
            'employee-export',

            // ================= DEPARTMENT =================
            'department-manage',
            'department-create',
            'department-edit',
            'department-delete',

            // ================= UNIT / LOCATION =================
            'unit-manage',
            'unit-create',
            'unit-edit',
            'unit-delete',

            'location-manage',
            'location-create',
            'location-edit',
            'location-delete',

            // ================= COMPANY =================
            'company-manage',
            'company-create',
            'company-edit',
            'company-delete',

            // ================= MAINTENANCE =================
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'maintenance-edit',
            'maintenance-delete',
            'maintenance-approve',
            'maintenance-history',

            'maintenance-type-manage',
            'maintenance-vendor-manage',
            'maintenance-schedule-manage',
            'maintenance-category-manage',

            // ================= TRIP SHEETS =================
            'trip-manage',
            'trip-sheet-view',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-export',

            // ================= REPORTS =================
            'report-requisition',
            'report-maintenance',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-export',

            // ================= DOCUMENT MANAGEMENT =================
            'document-manage',
            'document-create',
            'document-edit',
            'document-approve',
            'document-reject',
            'document-history',
            'document-export',

            // ================= SUBSCRIPTION & PAYMENTS =================
            'subscription-plan-manage',
            'subscription-purchase',
            'subscription-approve',
            'subscription-view',

            'payment-view',
            'payment-approve',
            'payment-reject',
            'payment-invoice',

            // ================= SUPPORT =================
            'support-manage',
            'support-create',
            'support-edit',
            'support-delete',
            'support-emergency',

            // ================= USER & ROLE MANAGEMENT =================
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

            // ================= SETTINGS =================
            'settings-manage',
            'settings-language',
            'settings-notification',

            // ================= TRANSLATION =================
            'translation-manage',
            'translation-create',
            'translation-update',
            'translation-auto',

            // ================= NOTIFICATION =================
            'notification-view',
            'notification-manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |----------------------------------------------------------
        | Default Roles
        |----------------------------------------------------------
        */
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $admin      = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $transport  = Role::firstOrCreate(['name' => 'Transport', 'guard_name' => 'web']);
        $employee   = Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
        $deptHead   = Role::firstOrCreate(['name' => 'Department Head', 'guard_name' => 'web']);
        $manager    = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);

        // Super Admin gets everything
        $superAdmin->syncPermissions(Permission::all());

        // Admin permissions
        $admin->syncPermissions([
            'dashboard',
            'requisition-view',
            'department-approval-view',
            'transport-approval-view',
            'trip-sheet-view',
            'company-manage',
            'employee-manage',
            'department-manage',
            'unit-manage',
            'location-manage',
            'driver-manage',
            'driver-create',
            'driver-edit',
            'driver-view',
            'driver-export',
            'driver-document-manage',
            'driver-document-upload',
            'driver-document-view',
            'driver-schedule-manage',
            'driver-schedule-view',
            'driver-performance-manage',
            'driver-performance-view',
            'vehicle-manage',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-view',
            'vehicle-export',
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'maintenance-edit',
            'report-requisition',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-export',
        ]);

        // Transport role permissions
        $transport->syncPermissions([
            'dashboard',
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'trip-manage',
            'trip-sheet-view',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'driver-manage',
            'driver-view',
            'driver-schedule-manage',
            'driver-schedule-view',
            'driver-schedule-assign',
            'driver-availability-manage',
            'driver-availability-view',
            'driver-availability-update',
            'vehicle-manage',
            'vehicle-view',
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'report-trip-fuel',
            'report-vehicle-utilization',
        ]);

        // Employee permissions
        $employee->syncPermissions([
            'dashboard',
            'requisition-create',
            'requisition-view',
        ]);

        // Department Head permissions
        $deptHead->syncPermissions([
            'dashboard',
            'requisition-view',
            'requisition-create',
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',
        ]);

        // Manager permissions
        $manager->syncPermissions([
            'dashboard',
            'requisition-view',
            'requisition-create',
            'requisition-approve',
            'department-approval-view',
            'department-approval-approve',
            'transport-approval-view',
            'trip-sheet-view',
            'trip-manage',
            'driver-view',
            'driver-performance-view',
            'driver-performance-report',
            'vehicle-view',
            'report-requisition',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
        ]);

        $this->command->info('Permission seeder completed successfully!');
        $this->command->info('Total permissions: ' . count($permissions));
    }
}

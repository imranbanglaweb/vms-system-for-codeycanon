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

            // ================= DRIVER MANAGEMENT =================
            'driver-manage',
            'driver-create',
            'driver-edit',
            'driver-delete',
            'license-type-manage',

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
            'trip-start',
            'trip-finish',
            'trip-end',

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

        // Super Admin gets everything
        $superAdmin->syncPermissions(Permission::all());

        // Admin permissions
        $admin->syncPermissions([
            'dashboard',
            'requisition-view',
            'department-approval-view',
            'transport-approval-view',
            'trip-sheet-view',
        ]);

        // Transport role permissions
        $transport->syncPermissions([
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'trip-manage',
            'trip-start',
            'trip-finish',
            'trip-end',
        ]);

        // Employee permissions
        $employee->syncPermissions([
            'dashboard',
            'requisition-create',
            'requisition-view',
        ]);
    }
}

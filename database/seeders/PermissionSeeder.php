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
            'menu-create',
            'menu-edit',
            'menu-delete',
            'menu-reorder',
            'menu-manage',
            'menu-list',

            // ================= REQUISITIONS =================
            'requisition-create',
            'requisition-view',
            'requisition-approve',
            'requisition-assign',
            'requisition-workflow-update',
            'requisition-export',
            'requisition-download',
            'requisition-approved-view',
            'requisition-pending-view',

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
            'department-approve',

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

            // ================= TRIP & TRANSPORT =================
            'trip-manage',
            'trip-start',
            'trip-finish',
            'trip-sheet-view',

            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'transport-approval-reject',

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

            // ================= SUPPORT / TASK =================
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

            // ================= MENU & SETTINGS =================
            // 'menu-manage', // Added above
            // 'menu-create',
            // 'menu-edit',
            // 'menu-delete',
            // 'menu-reorder',

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

        // ================= OPTIONAL DEFAULT ROLES =================
        $roles = [
            'Super Admin',
            'Admin',
            'Transport',
            'Employee',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
        }
    }
}

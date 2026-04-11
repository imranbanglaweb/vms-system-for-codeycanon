<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Schema::disableForeignKeyConstraints();
        DB::table('menus')->truncate();
        Schema::enableForeignKeyConstraints();

        $adminId = 1;
        $now = Carbon::now();

        // Define all permissions used in menus
        $allPermissions = [
            // Dashboard
            'dashboard',

            // Settings
            'settings-manage',
            'settings-notification',
            'settings-language',

            // Roles & Permissions
            'role-manage',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-manage',
            'permission-create',
            'permission-edit',
            'permission-delete',

            // Users
            'user-manage',
            'user-create',
            'user-edit',
            'user-delete',

            // Menu Management
            'menu-manage',
            'menu-create',
            'menu-edit',
            'menu-delete',
            'menu-list',
            'menu-reorder',

            // Employees
            'employee-manage',
            'employee-create',
            'employee-edit',
            'employee-delete',
            'employee-import',
            'employee-export',
            'employee-view-own',
            'employee-edit-own',
            'employee-create-department',
            'employee-edit-department',
            'employee-delete-department',
            'employee-list-department',
            'unit-manage',
            'unit-create',
            'unit-edit',
            'unit-delete',
            'company-manage',
            'company-create',
            'company-edit',
            'company-delete',
            'location-manage',
            'location-create',
            'location-edit',
            'location-delete',
            'department-manage',
            'department-create',
            'department-edit',
            'department-delete',
            'department-head-manage',
            'license-type-manage',

            // Drivers
            'driver-manage',
            'driver-create',
            'driver-edit',
            'driver-delete',
            'driver-view',
            'driver-export',
            'driver-document-manage',
            'driver-document-upload',
            'driver-document-view',
            'driver-document-delete',
            'driver-document-approve',
            'driver-schedule-view',
            'driver-schedule-own',
            'driver-schedule-manage',
            'driver-schedule-assign',
            'driver-schedule-edit',
            'driver-performance-view',
            'driver-performance-manage',
            'driver-performance-report',
            'driver-access',
            'driver-list-view',
            'driver-list-department',
            'driver-vehicle',
            'driver-availability-view',
            'driver-availability-update',
            'driver-availability-manage',

            // Vehicles
            'vehicle-manage',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',
            'vehicle-view',
            'vehicle-export',
            'vehicle-type-manage',
            'vehicle-list-view',
            'vehicle-list-department',

            // Maintenance (Unified)
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'maintenance-edit',
            'maintenance-approve',
            'maintenance-history',
            'maintenance-type-manage',
            'maintenance-vendor-manage',
            'maintenance-category-manage',
            'maintenance-approval-view',
            'maintenance-approval-department',

            // Requisitions
            'requisition-create',
            'requisition-view',
            'requisition-edit',
            'requisition-delete',
            'requisition-export',
            'requisition-download',
            'requisition-approve',
            'requisition-pending-view',
            'requisition-approved-view',
            'my-requisitions',

            // Department Approval
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',
            'requisition-approval-department',

            // Transport Approval
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'transport-approval-reject',

            // Trip Sheets
            'trip-manage',
            'trip-sheet-view',
            'trip-sheet-own',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-export',
            'trip-fuel-log',
            'trip-fuel-own',

            // Fuel Management
            'fuel-manage',
            'fuel-log-entry',
            'fuel-history-view',

            // Profile & Employee
            'profile-view',
            'profile-edit',

            // Documents
            'document-manage',
            'document-create',
            'document-edit',
            'document-delete',
            'document-view',
            'document-approve',
            'document-reject',
            'document-history',
            'document-export',
            'my-documents',

            // Support / Helpdesk
            'support-manage',
            'support-create',
            'support-edit',
            'support-view',
            'support-delete',
            'support-emergency',

            // Payments
            'payment-approve',
            'payment-view',

            // Reports
            'report-requisition',
            'report-requisition-own',
            'report-requisition-department',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-maintenance',
            'report-maintenance-own',
            'report-maintenance-department',
            'report-export',

            // Notifications
            'notification-manage',
            'notification-view',

            // Email Templates
            'email-template-manage',
            'emaillog-manage',

            // GPS Tracking
            'gps-tracking',
            'gps-tracking-view',

            // Tenant Management
            'tenant-manage',

            // Subscription Plans
            'subscription-plan-manage',
            'subscription-plan-create',
            'subscription-plan-edit',
            'subscription-plan-delete',
            'subscription-plan-view',

            // Tenant Management
            'tenant-manage',
            'tenant-activate',
            'tenant-deactivate',
            'tenant-data-export',
            'tenant-statistics-view',

            // Billing & Payments
            'billing-manage',
            'billing-view',
            'payment-reject',
            'payment-invoice',
            'invoice-manage',
            'invoice-view',

            // Usage & Analytics
            'usage-view',
            'analytics-view',
            'report-tenant-usage',
            'report-billing',

            // System Administration
            'system-configure',
            'webhook-manage',
            'api-key-manage',

            // Maintenance Schedule
            'maintenance-schedule-manage',

            // Driver Availability Own
            'driver-availability-own',

            // Trip Fuel View
            'trip-fuel-view',

            // Department Approval
            'department-approve',
            'transport-approve',

            // Translations
            'translation-manage',
            'translation-create',
            'translation-update',
            'translation-auto',
        ];

        // Create permissions if they don't exist
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }

        // Define parent menus with proper ordering (1-20)
        $parentMenus = [
            // 1. Dashboard
            [
                'menu_name' => 'Dashboard',
                'menu_slug' => 'menu.dashboard',
                'menu_icon' => 'fa-gauge',
                'menu_url' => 'home',
                'menu_permission' => 'dashboard',
                'menu_order' => 1,
                'menu_parent' => 0,
            ],

            // 2. Vehicle Requisition
            [
                'menu_name' => 'Vehicle Requisition',
                'menu_slug' => 'vehicle-requisition',
                'menu_icon' => 'fa-file-lines',
                'menu_url' => null,
                'menu_permission' => null,
                'menu_order' => 2,
                'menu_parent' => 0,
            ],

            // 3. Maintenance (Unified - Vehicle Maintenance + Maintenance Requisition)
            [
                'menu_name' => 'Maintenance',
                'menu_slug' => 'maintenance',
                'menu_icon' => 'fa-wrench',
                'menu_url' => null,
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 3,
                'menu_parent' => 0,
            ],

            // 4. Approvals
            [
                'menu_name' => 'Approvals',
                'menu_slug' => 'approvals',
                'menu_icon' => 'fa-check-circle',
                'menu_url' => null,
                'menu_permission' => 'department-approval-view',
                'menu_order' => 4,
                'menu_parent' => 0,
            ],

            // 5. Trip Sheets
            [
                'menu_name' => 'Trip Sheets',
                'menu_slug' => 'trip-sheets',
                'menu_icon' => 'fa-road',
                'menu_url' => null,
                'menu_permission' => 'trip-sheet-view',
                'menu_order' => 5,
                'menu_parent' => 0,
            ],

            // 6. Vehicle Management
            [
                'menu_name' => 'Vehicle Management',
                'menu_slug' => 'vehicle-management',
                'menu_icon' => 'fa-truck',
                'menu_url' => null,
                'menu_permission' => 'vehicle-list-view',
                'menu_order' => 6,
                'menu_parent' => 0,
            ],

            // 7. Driver Management
            [
                'menu_name' => 'Driver Management',
                'menu_slug' => 'driver-management',
                'menu_icon' => 'fa-id-card',
                'menu_url' => 'drivers.index',
                'menu_permission' => 'driver-list-view',
                'menu_order' => 7,
                'menu_parent' => 0,
            ],

            // 8. GPS Tracking
            [
                'menu_name' => 'GPS Tracking',
                'menu_slug' => 'gps-tracking',
                'menu_icon' => 'fa-map-marker-alt',
                'menu_url' => null,
                'menu_permission' => 'gps-tracking-view',
                'menu_order' => 8,
                'menu_parent' => 0,
            ],

            // 9. Fuel Management
            [
                'menu_name' => 'Fuel Management',
                'menu_slug' => 'fuel-management',
                'menu_icon' => 'fa-gas-pump',
                'menu_url' => null,
                'menu_permission' => null,
                'menu_order' => 9,
                'menu_parent' => 0,
            ],

            // 10. Reports
            [
                'menu_name' => 'Reports',
                'menu_slug' => 'menu.reports',
                'menu_icon' => 'fa-chart-simple',
                'menu_url' => null,
                'menu_permission' => 'report-requisition-own',
                'menu_order' => 10,
                'menu_parent' => 0,
            ],

            // 11. Employee Management
            [
                'menu_name' => 'Employee Management',
                'menu_slug' => 'employee-management',
                'menu_icon' => 'fa-users',
                'menu_url' => null,
                'menu_permission' => 'employee-manage',
                'menu_order' => 11,
                'menu_parent' => 0,
            ],

            // 12. User Management
            [
                'menu_name' => 'User Management',
                'menu_slug' => 'user-management',
                'menu_icon' => 'fa-user-circle',
                'menu_url' => null,
                'menu_permission' => 'user-manage',
                'menu_order' => 12,
                'menu_parent' => 0,
            ],

            // 13. Roles & Permissions
            [
                'menu_name' => 'Roles & Permissions',
                'menu_slug' => 'role-permission-manage',
                'menu_icon' => 'fa-shield-halved',
                'menu_url' => 'admin.roles.index',
                'menu_permission' => 'role-manage',
                'menu_order' => 13,
                'menu_parent' => 0,
            ],

            // 14. Company Management
            [
                'menu_name' => 'Company Management',
                'menu_slug' => 'company-management',
                'menu_icon' => 'fa-building',
                'menu_url' => null,
                'menu_permission' => 'company-manage',
                'menu_order' => 14,
                'menu_parent' => 0,
            ],

            // 15. Settings
            [
                'menu_name' => 'Settings',
                'menu_slug' => 'menu.settings',
                'menu_icon' => 'fa-cogs',
                'menu_url' => 'settings.index',
                'menu_permission' => 'settings-manage',
                'menu_order' => 15,
                'menu_parent' => 0,
            ],

            // 16. Email & Notification
            [
                'menu_name' => 'Email & Notification',
                'menu_slug' => 'email-notification',
                'menu_icon' => 'fa-bell',
                'menu_url' => null,
                'menu_permission' => 'settings-notification',
                'menu_order' => 16,
                'menu_parent' => 0,
            ],

            // 17. AI Features
            [
                'menu_name' => 'AI Features',
                'menu_slug' => 'ai-features',
                'menu_icon' => 'fa-brain',
                'menu_url' => null,
                'menu_permission' => null,
                'menu_order' => 17,
                'menu_parent' => 0,
            ],

            // 18. Public Pages (Admin only)
            [
                'menu_name' => 'Public Pages',
                'menu_slug' => 'public-pages',
                'menu_icon' => 'fa-globe',
                'menu_url' => 'pricing',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 18,
                'menu_parent' => 0,
            ],

            // 18. Translations
            [
                'menu_name' => 'Translations',
                'menu_slug' => 'translations-manage',
                'menu_icon' => 'fa-language',
                'menu_url' => null,
                'menu_permission' => 'translation-manage',
                'menu_order' => 18,
                'menu_parent' => 0,
            ],

            // 19. My Profile
            [
                'menu_name' => 'My Profile',
                'menu_slug' => 'my-profile',
                'menu_icon' => 'fa-user',
                'menu_url' => 'user-profile',
                'menu_permission' => 'employee-view-own',
                'menu_order' => 19,
                'menu_parent' => 0,
            ],

            // 20. Menu Management
            [
                'menu_name' => 'Menu Management',
                'menu_slug' => 'menu-manage',
                'menu_icon' => 'fa-sitemap',
                'menu_url' => null,
                'menu_permission' => 'menu-manage',
                'menu_order' => 20,
                'menu_parent' => 0,
            ],
        ];

        // Insert parent menus and create parent ID map
        $parentIdMap = [];
        foreach ($parentMenus as $menu) {
            $id = DB::table('menus')->insertGetId([
                'menu_name' => $menu['menu_name'],
                'menu_slug' => $menu['menu_slug'],
                'menu_icon' => $menu['menu_icon'],
                'menu_url' => $menu['menu_url'],
                'menu_permission' => $menu['menu_permission'],
                'menu_order' => $menu['menu_order'],
                'menu_parent' => $menu['menu_parent'],
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $parentIdMap[$menu['menu_name']] = $id;
        }

        // Now insert child menus with correct parent IDs
        $childMenus = [
            // ===== Vehicle Requisition Children (Order: 1-5) =====
            [
                'menu_name' => 'Requisition List',
                'menu_slug' => 'requisition-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'requisitions.index',
                'menu_permission' => 'requisition-view',
                'menu_order' => 1,
                'parent_name' => 'Vehicle Requisition',
            ],
            [
                'menu_name' => 'New Requisition',
                'menu_slug' => 'new-requisition',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'requisitions.create',
                'menu_permission' => 'requisition-create',
                'menu_order' => 2,
                'parent_name' => 'Vehicle Requisition',
            ],

            // ===== Maintenance Children (Unified - Order: 1-6) =====
            [
                'menu_name' => 'All Maintenance Requests',
                'menu_slug' => 'maintenance-requests',
                'menu_icon' => 'fa-inbox',
                'menu_url' => 'maintenance.index',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 1,
                'parent_name' => 'Maintenance',
            ],
            [
                'menu_name' => 'Create Request',
                'menu_slug' => 'create-maintenance-request',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'maintenance.create',
                'menu_permission' => 'maintenance-create',
                'menu_order' => 2,
                'parent_name' => 'Maintenance',
            ],
            [
                'menu_name' => 'Maintenance Types',
                'menu_slug' => 'maintenance-types',
                'menu_icon' => 'fa-tag',
                'menu_url' => 'maintenance-types.index',
                'menu_permission' => 'maintenance-type-manage',
                'menu_order' => 3,
                'parent_name' => 'Maintenance',
            ],
            [
                'menu_name' => 'Service Vendors',
                'menu_slug' => 'maintenance-vendors',
                'menu_icon' => 'fa-building',
                'menu_url' => 'maintenance-vendors.index',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 4,
                'parent_name' => 'Maintenance',
            ],
            [
                'menu_name' => 'Maintenance Categories',
                'menu_slug' => 'maintenance-categories',
                'menu_icon' => 'fa-tags',
                'menu_url' => 'maintenance-categories.index',
                'menu_permission' => 'maintenance-category-manage',
                'menu_order' => 5,
                'parent_name' => 'Maintenance',
            ],
            [
                'menu_name' => 'Maintenance History',
                'menu_slug' => 'maintenance-history',
                'menu_icon' => 'fa-clock-rotate-left',
                'menu_url' => 'admin-maintenance.history',
                'menu_permission' => 'maintenance-view',
                'menu_order' => 6,
                'parent_name' => 'Maintenance',
            ],

            // ===== Approvals Children (Order: 1-10) =====
            [
                'menu_name' => 'Pending Requisitions',
                'menu_slug' => 'pending-requisitions',
                'menu_icon' => 'fa-hourglass-half',
                'menu_url' => 'department.approvals.index',
                'menu_permission' => 'department-approval-view',
                'menu_order' => 1,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Transport Approvals',
                'menu_slug' => 'transport-approvals',
                'menu_icon' => 'fa-truck',
                'menu_url' => 'transport.approvals.index',
                'menu_permission' => 'transport-approval-view',
                'menu_order' => 2,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Maintenance Approvals',
                'menu_slug' => 'maintenance-approvals',
                'menu_icon' => 'fa-tools',
                'menu_url' => 'admin.maintenance_approvals.index',
                'menu_permission' => 'maintenance-approval-view',
                'menu_order' => 3,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Maintenance Transport',
                'menu_slug' => 'maintenance-transport',
                'menu_icon' => 'fa-truck-loading',
                'menu_url' => 'admin.maintenance_transport_approvals.index',
                'menu_permission' => 'maintenance-approval-view',
                'menu_order' => 4,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Approved Requisitions',
                'menu_slug' => 'approved-requisitions',
                'menu_icon' => 'fa-check-circle',
                'menu_url' => 'department.approvals.approved',
                'menu_permission' => 'requisition-approval-department',
                'menu_order' => 5,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Rejected Requisitions',
                'menu_slug' => 'rejected-requisitions',
                'menu_icon' => 'fa-times-circle',
                'menu_url' => 'department.approvals.rejected',
                'menu_permission' => 'requisition-approval-department',
                'menu_order' => 6,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'My Pending Approvals',
                'menu_slug' => 'my-pending-approvals',
                'menu_icon' => 'fa-inbox',
                'menu_url' => 'department.approvals.my',
                'menu_permission' => 'requisition-approval-department',
                'menu_order' => 7,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Maintenance Pending',
                'menu_slug' => 'maintenance-pending',
                'menu_icon' => 'fa-clock',
                'menu_url' => 'maintenance_approvals.index',
                'menu_permission' => 'maintenance-approval-view',
                'menu_order' => 8,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Maintenance Approved',
                'menu_slug' => 'maintenance-approved-list',
                'menu_icon' => 'fa-check',
                'menu_url' => 'maintenance_approvals.approved',
                'menu_permission' => 'maintenance-approval-view',
                'menu_order' => 9,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Maintenance Transport',
                'menu_slug' => 'maintenance-transport',
                'menu_icon' => 'fa-truck-loading',
                'menu_url' => 'maintenance_transport_approvals.index',
                'menu_permission' => 'maintenance-approval-view',
                'menu_order' => 10,
                'parent_name' => 'Approvals',
            ],

            // ===== Trip Sheets Children (Order: 1-5) =====
            [
                'menu_name' => 'All Trip Sheets',
                'menu_slug' => 'all-trip-sheets',
                'menu_icon' => 'fa-list',
                'menu_url' => 'trip-sheets.index',
                'menu_permission' => 'trip-sheet-view',
                'menu_order' => 1,
                'parent_name' => 'Trip Sheets',
            ],
            [
                'menu_name' => 'Create Trip',
                'menu_slug' => 'create-trip',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'trip-sheets.create',
                'menu_permission' => 'trip-manage',
                'menu_order' => 2,
                'parent_name' => 'Trip Sheets',
            ],
            [
                'menu_name' => 'My Trips',
                'menu_slug' => 'my-trips',
                'menu_icon' => 'fa-user',
                'menu_url' => 'trip-sheets.my',
                'menu_permission' => 'trip-sheet-own',
                'menu_order' => 3,
                'parent_name' => 'Trip Sheets',
            ],
            [
                'menu_name' => 'Active Trips',
                'menu_slug' => 'active-trips',
                'menu_icon' => 'fa-play-circle',
                'menu_url' => 'trip-sheets.active',
                'menu_permission' => 'trip-sheet-view',
                'menu_order' => 4,
                'parent_name' => 'Trip Sheets',
            ],
            [
                'menu_name' => 'Completed Trips',
                'menu_slug' => 'completed-trips',
                'menu_icon' => 'fa-check-double',
                'menu_url' => 'trip-sheets.completed',
                'menu_permission' => 'trip-sheet-view',
                'menu_order' => 5,
                'parent_name' => 'Trip Sheets',
            ],

// ===== Vehicle Management Children (Order: 1-8) =====
            [
                'menu_name' => 'Vehicle List',
                'menu_slug' => 'vehicle-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'vehicles.index',
                'menu_permission' => 'vehicle-list-view',
                'menu_order' => 1,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Add Vehicle',
                'menu_slug' => 'add-vehicle',
                'menu_icon' => 'fa-plus',
                'menu_url' => 'vehicles.create',
                'menu_permission' => 'vehicle-create',
                'menu_order' => 2,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Vehicle Types',
                'menu_slug' => 'vehicle-types',
                'menu_icon' => 'fa-car',
                'menu_url' => 'vehicle-type.index',
                'menu_permission' => 'vehicle-type-manage',
                'menu_order' => 3,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Vendor List',
                'menu_slug' => 'vendor-list',
                'menu_icon' => 'fa-store',
                'menu_url' => 'vendors.index',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 4,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Add Vendor',
                'menu_slug' => 'add-vendor',
                'menu_icon' => 'fa-plus-square',
                'menu_url' => 'vendors.create',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 5,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Add Vehicle',
                'menu_slug' => 'add-vehicle',
                'menu_icon' => 'fa-plus',
                'menu_url' => 'vehicles.create',
                'menu_permission' => 'vehicle-create',
                'menu_order' => 2,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Vehicle Types',
                'menu_slug' => 'vehicle-types',
                'menu_icon' => 'fa-car',
                'menu_url' => 'vehicle-type.index',
                'menu_permission' => 'vehicle-type-manage',
                'menu_order' => 3,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Vendor List',
                'menu_slug' => 'vendor-list',
                'menu_icon' => 'fa-store',
                'menu_url' => 'vendors.index',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 4,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Add Vendor',
                'menu_slug' => 'add-vendor',
                'menu_icon' => 'fa-plus-square',
                'menu_url' => 'vendors.create',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 5,
                'parent_name' => 'Vehicle Management',
            ],

            // ===== Driver Management Children (Order: 1-10) =====
            [
                'menu_name' => 'Driver List',
                'menu_slug' => 'driver-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'drivers.index',
                'menu_permission' => 'driver-manage',
                'menu_order' => 1,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Add Driver',
                'menu_slug' => 'add-driver',
                'menu_icon' => 'fa-user-plus',
                'menu_url' => 'drivers.create',
                'menu_permission' => 'driver-create',
                'menu_order' => 2,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Driver Documents',
                'menu_slug' => 'driver-documents',
                'menu_icon' => 'fa-file-alt',
                'menu_url' => 'driver-documents.index',
                'menu_permission' => 'driver-document-manage',
                'menu_order' => 3,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Driver Performance',
                'menu_slug' => 'driver-performance',
                'menu_icon' => 'fa-chart-line',
                'menu_url' => 'driver_performance',
                'menu_permission' => 'driver-performance-view',
                'menu_order' => 4,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'License Types',
                'menu_slug' => 'license-types',
                'menu_icon' => 'fa-id-card',
                'menu_url' => 'license-types.index',
                'menu_permission' => 'license-type-manage',
                'menu_order' => 5,
                'parent_name' => 'Driver Management',
            ],
            // Driver Personal Section
            [
                'menu_name' => 'My Dashboard',
                'menu_slug' => 'driver-dashboard',
                'menu_icon' => 'fa-tachometer-alt',
                'menu_url' => 'driver.dashboard',
                'menu_permission' => 'driver-access',
                'menu_order' => 6,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'My Schedule',
                'menu_slug' => 'driver-schedule',
                'menu_icon' => 'fa-calendar-alt',
                'menu_url' => 'driver.schedule',
                'menu_permission' => 'driver-access',
                'menu_order' => 7,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'My Trips',
                'menu_slug' => 'driver-trips',
                'menu_icon' => 'fa-route',
                'menu_url' => 'driver.trips',
                'menu_permission' => 'driver-access',
                'menu_order' => 8,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'My Availability',
                'menu_slug' => 'driver-availability',
                'menu_icon' => 'fa-clock',
                'menu_url' => 'driver.availability',
                'menu_permission' => 'driver-access',
                'menu_order' => 9,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'My Vehicle',
                'menu_slug' => 'driver-vehicle',
                'menu_icon' => 'fa-truck-moving',
                'menu_url' => 'driver.vehicle',
                'menu_permission' => 'driver-access',
                'menu_order' => 10,
                'parent_name' => 'Driver Management',
            ],

            // ===== GPS Tracking Children (Order: 1-5) =====
            [
                'menu_name' => 'Live Tracking',
                'menu_slug' => 'live-tracking',
                'menu_icon' => 'fa-satellite-dish',
                'menu_url' => 'admin.gps-tracking.index',
                'menu_permission' => 'gps-tracking-view',
                'menu_order' => 1,
                'parent_name' => 'GPS Tracking',
            ],
            [
                'menu_name' => 'Vehicle Tracking',
                'menu_slug' => 'vehicle-tracking',
                'menu_icon' => 'fa-car-side',
                'menu_url' => 'admin.gps-tracking.vehicle',
                'menu_permission' => 'gps-tracking-view',
                'menu_order' => 2,
                'parent_name' => 'GPS Tracking',
            ],
            [
                'menu_name' => 'Trip Tracking',
                'menu_slug' => 'trip-tracking',
                'menu_icon' => 'fa-route',
                'menu_url' => 'admin.gps-tracking.trip',
                'menu_permission' => 'gps-tracking-view',
                'menu_order' => 3,
                'parent_name' => 'GPS Tracking',
            ],
            [
                'menu_name' => 'Device Management',
                'menu_slug' => 'device-management',
                'menu_icon' => 'fa-microchip',
                'menu_url' => 'admin.gps-devices.index',
                'menu_permission' => 'gps-tracking',
                'menu_order' => 4,
                'parent_name' => 'GPS Tracking',
            ],
            [
                'menu_name' => 'Add Device',
                'menu_slug' => 'add-gps-device',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'admin.gps-devices.create',
                'menu_permission' => 'gps-tracking',
                'menu_order' => 5,
                'parent_name' => 'GPS Tracking',
            ],

            // ===== Fuel Management Children (Order: 1-6) =====
            [
                'menu_name' => 'Fuel Logs',
                'menu_slug' => 'fuel-logs',
                'menu_icon' => 'fa-list',
                'menu_url' => 'driver.fuel.log',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 1,
                'parent_name' => 'Fuel Management',
            ],
            [
                'menu_name' => 'Fuel Purchase',
                'menu_slug' => 'fuel-purchase',
                'menu_icon' => 'fa-shopping-cart',
                'menu_url' => 'driver.fuel.purchase.log',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 2,
                'parent_name' => 'Fuel Management',
            ],
            [
                'menu_name' => 'Fuel History',
                'menu_slug' => 'fuel-history',
                'menu_icon' => 'fa-history',
                'menu_url' => 'driver.fuel.history',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 3,
                'parent_name' => 'Fuel Management',
            ],
            [
                'menu_name' => 'Monthly Summary',
                'menu_slug' => 'fuel-monthly-summary',
                'menu_icon' => 'fa-calendar-alt',
                'menu_url' => 'driver.fuel.monthly.summary',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 4,
                'parent_name' => 'Fuel Management',
            ],
            [
                'menu_name' => 'Fuel Efficiency',
                'menu_slug' => 'fuel-efficiency',
                'menu_icon' => 'fa-chart-line',
                'menu_url' => 'driver.fuel.efficiency',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 5,
                'parent_name' => 'Fuel Management',
            ],

            // ===== Reports Children (Order: 1-7) =====
            [
                'menu_name' => 'Requisition Report',
                'menu_slug' => 'requisition-report',
                'menu_icon' => 'fa-file-alt',
                'menu_url' => 'reports.requisitions',
                'menu_permission' => 'report-requisition',
                'menu_order' => 1,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'My Requisition Report',
                'menu_slug' => 'my-requisition-report',
                'menu_icon' => 'fa-file-alt',
                'menu_url' => 'reports.requisitions',
                'menu_permission' => 'report-requisition-own',
                'menu_order' => 2,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Vehicle Utilization',
                'menu_slug' => 'vehicle-utilization-report',
                'menu_icon' => 'fa-car',
                'menu_url' => 'reports.vehicle_utilization',
                'menu_permission' => 'report-vehicle-utilization',
                'menu_order' => 3,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Trip & Fuel Report',
                'menu_slug' => 'trip-fuel-report',
                'menu_icon' => 'fa-gas-pump',
                'menu_url' => 'reports.trips_fuel',
                'menu_permission' => 'report-trip-fuel',
                'menu_order' => 4,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Driver Performance',
                'menu_slug' => 'driver-performance-report',
                'menu_icon' => 'fa-id-card',
                'menu_url' => 'reports.driver_performance',
                'menu_permission' => 'report-driver-performance',
                'menu_order' => 5,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Maintenance Report',
                'menu_slug' => 'maintenance-report',
                'menu_icon' => 'fa-wrench',
                'menu_url' => 'reports.maintenance',
                'menu_permission' => 'report-maintenance',
                'menu_order' => 6,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'My Maintenance Report',
                'menu_slug' => 'my-maintenance-report',
                'menu_icon' => 'fa-wrench',
                'menu_url' => 'reports.maintenance',
                'menu_permission' => 'report-maintenance-own',
                'menu_order' => 7,
                'parent_name' => 'Reports',
            ],

            // ===== Employee Management Children (Order: 1-10) =====
            [
                'menu_name' => 'All Employees',
                'menu_slug' => 'all-employees',
                'menu_icon' => 'fa-users',
                'menu_url' => 'admin.employees.index',
                'menu_permission' => 'employee-manage',
                'menu_order' => 1,
                'parent_name' => 'Employee Management',
            ],
            [
                'menu_name' => 'Add Employee',
                'menu_slug' => 'add-employee',
                'menu_icon' => 'fa-user-plus',
                'menu_url' => 'admin.employees.create',
                'menu_permission' => 'employee-manage',
                'menu_order' => 2,
                'parent_name' => 'Employee Management',
            ],
            [
                'menu_name' => 'Departments',
                'menu_slug' => 'departments',
                'menu_icon' => 'fa-sitemap',
                'menu_url' => 'departments.index',
                'menu_permission' => 'department-manage',
                'menu_order' => 3,
                'parent_name' => 'Employee Management',
            ],
            [
                'menu_name' => 'Designations',
                'menu_slug' => 'designations',
                'menu_icon' => 'fa-briefcase',
                'menu_url' => 'designations.index',
                'menu_permission' => 'department-manage',
                'menu_order' => 4,
                'parent_name' => 'Employee Management',
            ],
            [
                'menu_name' => 'Units',
                'menu_slug' => 'units',
                'menu_icon' => 'fa-layer-group',
                'menu_url' => 'admin.units.index',
                'menu_permission' => 'unit-manage',
                'menu_order' => 5,
                'parent_name' => 'Employee Management',
            ],
            [
                'menu_name' => 'Locations',
                'menu_slug' => 'locations',
                'menu_icon' => 'fa-map-pin',
                'menu_url' => 'admin.locations.index',
                'menu_permission' => 'location-manage',
                'menu_order' => 6,
                'parent_name' => 'Employee Management',
            ],
            [
                'menu_name' => 'Department Heads',
                'menu_slug' => 'department-heads',
                'menu_icon' => 'fa-crown',
                'menu_url' => 'admin.department-heads.index',
                'menu_permission' => 'department-head-manage',
                'menu_order' => 7,
                'parent_name' => 'Employee Management',
            ],
            [
                'menu_name' => 'Employee Profiles',
                'menu_slug' => 'employee-profiles',
                'menu_icon' => 'fa-id-badge',
                'menu_url' => 'admin.employees.profiles',
                'menu_permission' => 'employee-manage',
                'menu_order' => 8,
                'parent_name' => 'Employee Management',
            ],
            [
                'menu_name' => 'Employee Approvals',
                'menu_slug' => 'employee-approvals',
                'menu_icon' => 'fa-check-double',
                'menu_url' => 'admin.employees.approvals',
                'menu_permission' => 'employee-manage',
                'menu_order' => 9,
                'parent_name' => 'Employee Management',
            ],
            [
                'menu_name' => 'Team Members',
                'menu_slug' => 'team-members',
                'menu_icon' => 'fa-user-friends',
                'menu_url' => 'admin.employees.department.index',
                'menu_permission' => 'employee-list-department',
                'menu_order' => 10,
                'parent_name' => 'Employee Management',
            ],

            // ===== User Management Children (Order: 1-3) =====
            [
                'menu_name' => 'User List',
                'menu_slug' => 'user-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'users.index',
                'menu_permission' => 'user-manage',
                'menu_order' => 1,
                'parent_name' => 'User Management',
            ],
            [
                'menu_name' => 'Add User',
                'menu_slug' => 'add-user',
                'menu_icon' => 'fa-user-plus',
                'menu_url' => 'users.create',
                'menu_permission' => 'user-create',
                'menu_order' => 2,
                'parent_name' => 'User Management',
            ],

            // ===== Roles & Permissions Children (Order: 1-3) =====
            [
                'menu_name' => 'All Roles',
                'menu_slug' => 'all-roles',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.roles.index',
                'menu_permission' => 'role-manage',
                'menu_order' => 1,
                'parent_name' => 'Roles & Permissions',
            ],
            [
                'menu_name' => 'Create Role',
                'menu_slug' => 'create-role',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'admin.roles.create',
                'menu_permission' => 'role-manage',
                'menu_order' => 2,
                'parent_name' => 'Roles & Permissions',
            ],
            [
                'menu_name' => 'All Permissions',
                'menu_slug' => 'all-permissions',
                'menu_icon' => 'fa-key',
                'menu_url' => 'admin.permissions.index',
                'menu_permission' => 'role-manage',
                'menu_order' => 3,
                'parent_name' => 'Roles & Permissions',
            ],

            // ===== Company Management Children (Order: 1-3) =====
            [
                'menu_name' => 'All Companies',
                'menu_slug' => 'all-companies',
                'menu_icon' => 'fa-building',
                'menu_url' => 'company.index',
                'menu_permission' => 'company-manage',
                'menu_order' => 1,
                'parent_name' => 'Company Management',
            ],
            [
                'menu_name' => 'Add Company',
                'menu_slug' => 'add-company',
                'menu_icon' => 'fa-plus-square',
                'menu_url' => 'company.create',
                'menu_permission' => 'company-manage',
                'menu_order' => 2,
                'parent_name' => 'Company Management',
            ],
            [
                'menu_name' => 'Subscription Plans',
                'menu_slug' => 'subscription-plans',
                'menu_icon' => 'fa-credit-card',
                'menu_url' => 'admin.dashboard.plans.index',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 3,
                'parent_name' => 'Company Management',
            ],
            [
                'menu_name' => 'Quota Management',
                'menu_slug' => 'quota-management',
                'menu_icon' => 'fa-tachometer-alt',
                'menu_url' => 'admin.quota-management.index',
                'menu_permission' => 'company-manage',
                'menu_order' => 4,
                'parent_name' => 'Company Management',
            ],

            // ===== Public Pages Children (Order: 1-6) =====
            [
                'menu_name' => 'Pricing Plans',
                'menu_slug' => 'pricing-plans',
                'menu_icon' => 'fa-tags',
                'menu_url' => 'pricing',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 1,
                'parent_name' => 'Public Pages',
            ],
            [
                'menu_name' => 'Pending Payments',
                'menu_slug' => 'pending-payments',
                'menu_icon' => 'fa-hourglass-half',
                'menu_url' => 'admin.payments.pending',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 2,
                'parent_name' => 'Public Pages',
            ],
            [
                'menu_name' => 'Paid Payments',
                'menu_slug' => 'paid-payments',
                'menu_icon' => 'fa-check-circle',
                'menu_url' => 'admin.payments.paid',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 3,
                'parent_name' => 'Public Pages',
            ],
            [
                'menu_name' => 'Revenue by Plan',
                'menu_slug' => 'revenue-plan',
                'menu_icon' => 'fa-chart-line',
                'menu_url' => 'admin.revenue.plans',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 4,
                'parent_name' => 'Public Pages',
            ],
            [
                'menu_name' => 'Expiring Subscriptions',
                'menu_slug' => 'expiring-subscriptions',
                'menu_icon' => 'fa-exclamation-triangle',
                'menu_url' => 'admin.payments.expiring',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 5,
                'parent_name' => 'Public Pages',
            ],
            [
                'menu_name' => 'Registered Users',
                'menu_slug' => 'registered-users',
                'menu_icon' => 'fa-user-plus',
                'menu_url' => 'admin.api-payments.users',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 6,
                'parent_name' => 'Public Pages',
            ],
            [
                'menu_name' => 'API Pending Payments',
                'menu_slug' => 'api-pending-payments',
                'menu_icon' => 'fa-clock',
                'menu_url' => 'admin.api-payments.pending',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 7,
                'parent_name' => 'Public Pages',
            ],
            [
                'menu_name' => 'API Paid Payments',
                'menu_slug' => 'api-paid-payments',
                'menu_icon' => 'fa-check',
                'menu_url' => 'admin.api-payments.paid',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 8,
                'parent_name' => 'Public Pages',
            ],

            // ===== Settings Children (Order: 1-3) =====
            [
                'menu_name' => 'My Subscription',
                'menu_slug' => 'my-subscription',
                'menu_icon' => 'fa-credit-card',
                'menu_url' => 'my.subscription',
                'menu_permission' => 'my-subscription',
                'menu_order' => 0,
                'parent_name' => 'Settings',
            ],
            [
                'menu_name' => 'General Settings',
                'menu_slug' => 'general-settings',
                'menu_icon' => 'fa-sliders-h',
                'menu_url' => 'settings.index',
                'menu_permission' => 'settings-manage',
                'menu_order' => 1,
                'parent_name' => 'Settings',
            ],
            [
                'menu_name' => 'Language Settings',
                'menu_slug' => 'language-settings',
                'menu_icon' => 'fa-language',
                'menu_url' => 'settings.language',
                'menu_permission' => 'settings-language',
                'menu_order' => 2,
                'parent_name' => 'Settings',
            ],

            // ===== Email & Notification Children (Order: 1-5) =====
            [
                'menu_name' => 'Email Templates',
                'menu_slug' => 'email-templates',
                'menu_icon' => 'fa-envelope-open',
                'menu_url' => 'email-templates.index',
                'menu_permission' => 'email-template-manage',
                'menu_order' => 1,
                'parent_name' => 'Email & Notification',
            ],
            [
                'menu_name' => 'Email Logs',
                'menu_slug' => 'email-logs',
                'menu_icon' => 'fa-envelope',
                'menu_url' => 'emaillogs.index',
                'menu_permission' => 'emaillog-manage',
                'menu_order' => 2,
                'parent_name' => 'Email & Notification',
            ],
            [
                'menu_name' => 'Notification Settings',
                'menu_slug' => 'notification-settings',
                'menu_icon' => 'fa-bell',
                'menu_url' => 'settings.notifications',
                'menu_permission' => 'settings-notification',
                'menu_order' => 3,
                'parent_name' => 'Email & Notification',
            ],
            [
                'menu_name' => 'Push Subscribers',
                'menu_slug' => 'push-subscribers',
                'menu_icon' => 'fa-bell',
                'menu_url' => 'admin.push.subscribers',
                'menu_permission' => 'settings-notification',
                'menu_order' => 4,
                'parent_name' => 'Email & Notification',
            ],

            // ===== AI Features Children (Order: 1-5) =====
            [
                'menu_name' => 'Maintenance Alerts',
                'menu_slug' => 'ai-maintenance-alerts',
                'menu_icon' => 'fa-lightbulb',
                'menu_url' => 'ai-maintenance-alerts.index',
                'menu_permission' => null,
                'menu_order' => 1,
                'parent_name' => 'AI Features',
            ],
            [
                'menu_name' => 'Generate Alert',
                'menu_slug' => 'generate-ai-alert',
                'menu_icon' => 'fa-magic',
                'menu_url' => 'ai-maintenance-alerts.generate',
                'menu_permission' => null,
                'menu_order' => 2,
                'parent_name' => 'AI Features',
            ],
            [
                'menu_name' => 'AI Reports',
                'menu_slug' => 'ai-reports',
                'menu_icon' => 'fa-robot',
                'menu_url' => 'ai-reports.index',
                'menu_permission' => null,
                'menu_order' => 3,
                'parent_name' => 'AI Features',
            ],
            [
                'menu_name' => 'Create Report',
                'menu_slug' => 'create-ai-report',
                'menu_icon' => 'fa-file-excel',
                'menu_url' => 'ai-reports.create',
                'menu_permission' => null,
                'menu_order' => 4,
                'parent_name' => 'AI Features',
            ],
            [
                'menu_name' => 'Reports Dashboard',
                'menu_slug' => 'ai-reports-dashboard',
                'menu_icon' => 'fa-chart-line',
                'menu_url' => 'ai-reports.dashboard',
                'menu_permission' => null,
                'menu_order' => 5,
                'parent_name' => 'AI Features',
            ],

            // ===== Translations Children (Order: 1-2) =====
            [
                'menu_name' => 'Manage Translations',
                'menu_slug' => 'manage-translations',
                'menu_icon' => 'fa-edit',
                'menu_url' => 'admin.translations',
                'menu_permission' => 'translation-manage',
                'menu_order' => 1,
                'parent_name' => 'Translations',
            ],
            [
                'menu_name' => 'Languages',
                'menu_slug' => 'manage-languages',
                'menu_icon' => 'fa-globe',
                'menu_url' => 'admin.languages.index',
                'menu_permission' => 'translation-manage',
                'menu_order' => 2,
                'parent_name' => 'Translations',
            ],

            // ===== My Profile Children (Order: 1-5) =====
            [
                'menu_name' => 'Profile Information',
                'menu_slug' => 'profile-info',
                'menu_icon' => 'fa-user-circle',
                'menu_url' => 'user-profile',
                'menu_permission' => 'profile-view',
                'menu_order' => 1,
                'parent_name' => 'My Profile',
            ],
            [
                'menu_name' => 'Edit Profile',
                'menu_slug' => 'edit-profile',
                'menu_icon' => 'fa-edit',
                'menu_url' => 'user-profile?tab=edit',
                'menu_permission' => 'profile-edit',
                'menu_order' => 2,
                'parent_name' => 'My Profile',
            ],
            [
                'menu_name' => 'Change Password',
                'menu_slug' => 'change-password',
                'menu_icon' => 'fa-lock',
                'menu_url' => 'user-profile?tab=password',
                'menu_permission' => 'profile-edit',
                'menu_order' => 3,
                'parent_name' => 'My Profile',
            ],
            [
                'menu_name' => 'My Documents',
                'menu_slug' => 'my-documents',
                'menu_icon' => 'fa-file-alt',
                'menu_url' => 'user-profile?tab=documents',
                'menu_permission' => 'my-documents',
                'menu_order' => 4,
                'parent_name' => 'My Profile',
            ],
            [
                'menu_name' => 'My Trip Sheets',
                'menu_slug' => 'my-trips',
                'menu_icon' => 'fa-road',
                'menu_url' => 'trip-sheets.my',
                'menu_permission' => 'trip-sheet-own',
                'menu_order' => 5,
                'parent_name' => 'My Profile',
            ],

            // ===== Menu Management Children (Order: 1-2) =====
            [
                'menu_name' => 'All Menus',
                'menu_slug' => 'all-menus',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.menus.index',
                'menu_permission' => 'menu-manage',
                'menu_order' => 1,
                'parent_name' => 'Menu Management',
            ],
            [
                'menu_name' => 'Add Menu',
                'menu_slug' => 'add-menu',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'admin.menus.create',
                'menu_permission' => 'menu-manage',
                'menu_order' => 2,
                'parent_name' => 'Menu Management',
            ],
        ];

        // Insert child menus with correct parent_id and sequential ordering
        foreach ($childMenus as $child) {
            $parentName = $child['parent_name'];
            $parentId = $parentIdMap[$parentName] ?? 0;
            
            DB::table('menus')->insert([
                'menu_name' => $child['menu_name'],
                'menu_slug' => $child['menu_slug'],
                'menu_icon' => $child['menu_icon'],
                'menu_url' => $child['menu_url'],
                'menu_permission' => $child['menu_permission'],
                'menu_order' => $child['menu_order'],
                'menu_parent' => $parentId,
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('Menu seeder completed successfully!');
        $this->command->info('Total parent menus: ' . count($parentMenus));
        $this->command->info('Total child menus: ' . count($childMenus));
    }
}

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

            // Users
            'user-manage',
            'user-create',

            // Menu Management
            'menu-manage',

            // Employees
            'employee-manage',
            'unit-manage',
            'company-manage',
            'location-manage',
            'department-manage',
            'department-head-manage',
            'license-type-manage',

            // Drivers
            'driver-manage',
            'driver-create',
            'driver-view',
            'driver-export',
            'driver-document-manage',
            'driver-document-upload',
            'driver-document-view',
            'driver-schedule-view',
            'driver-performance-view',
            'driver-access',

            // Vehicles
            'vehicle-manage',
            'vehicle-create',
            'vehicle-view',
            'vehicle-type-manage',

            // Maintenance
            'maintenance-manage',
            'maintenance-type-manage',
            'maintenance-vendor-manage',
            'maintenance-category-manage',
            'maintenance-approval-view',

            // Requisitions
            'requisition-create',
            'requisition-view',

            // Department Approval
            'department-approval-view',

            // Transport Approval
            'transport-approval-view',

            // Trip Sheets
            'trip-manage',
            'trip-sheet-view',

            // Payments
            'payment-approve',
            'payment-view',

            // Reports
            'report-requisition',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-maintenance',

            // Notifications
            'notification-manage',

            // Email Templates
            'email-template-manage',
            'emaillog-manage',
        ];

        // Create permissions if they don't exist
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }

        // Define parent menus first with their structure (ordered as specified)
        $parentMenus = [
            // Dashboard at the top
            [
                'menu_name' => 'Dashboard',
                'menu_slug' => 'menu.dashboard',
                'menu_icon' => 'fa-gauge',
                'menu_url' => 'home',
                'menu_permission' => 'dashboard',
                'menu_order' => 1,
                'menu_parent' => 0,
            ],
            // Management menus
            [
                'menu_name' => 'Settings',
                'menu_slug' => 'menu.settings',
                'menu_icon' => 'fa-cogs',
                'menu_url' => 'settings.index',
                'menu_permission' => 'settings-manage',
                'menu_order' => 2,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'User Manage',
                'menu_slug' => 'User-Manage',
                'menu_icon' => 'fa-user-circle',
                'menu_url' => null,
                'menu_permission' => 'user-manage',
                'menu_order' => 3,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Menu Manage',
                'menu_slug' => 'menu-Manage',
                'menu_icon' => 'fa-sitemap',
                'menu_url' => null,
                'menu_permission' => 'menu-manage',
                'menu_order' => 4,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Roles & Permissions',
                'menu_slug' => 'Role-Permission-Manage',
                'menu_icon' => 'fa-shield-halved',
                'menu_url' => 'admin.roles.index',
                'menu_permission' => 'role-manage',
                'menu_order' => 5,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Employee Manage',
                'menu_slug' => 'menu.employee',
                'menu_icon' => 'fa-users',
                'menu_url' => null,
                'menu_permission' => 'employee-manage',
                'menu_order' => 6,
                'menu_parent' => 0,
            ],
            // Core operational menus
            [
                'menu_name' => 'Driver Management',
                'menu_slug' => 'driver-manage',
                'menu_icon' => 'fa-id-card',
                'menu_url' => 'drivers.index',
                'menu_permission' => null,
                'menu_order' => 7,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Vehicle Management',
                'menu_slug' => 'vehicle-managemant',
                'menu_icon' => 'fa-truck',
                'menu_url' => null,
                'menu_permission' => 'vehicle-manage',
                'menu_order' => 8,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Vehicle Maintenance',
                'menu_slug' => 'menu.maintenance',
                'menu_icon' => 'fa-wrench',
                'menu_url' => null,
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 9,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Vehicle Requisition',
                'menu_slug' => 'vehicle-requisition',
                'menu_icon' => 'fa-file-lines',
                'menu_url' => null,
                'menu_permission' => 'requisition-view',
                'menu_order' => 10,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Approvals',
                'menu_slug' => 'approvals',
                'menu_icon' => 'fa-check-circle',
                'menu_url' => null,
                'menu_permission' => 'department-approval-view',
                'menu_order' => 11,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Trip Sheets',
                'menu_slug' => 'trip-sheets',
                'menu_icon' => 'fa-road',
                'menu_url' => null,
                'menu_permission' => 'trip-manage',
                'menu_order' => 12,
                'menu_parent' => 0,
            ],
            // Reports at the bottom
            [
                'menu_name' => 'Reports',
                'menu_slug' => 'menu.reports',
                'menu_icon' => 'fa-chart-simple',
                'menu_url' => null,
                'menu_permission' => 'report-requisition',
                'menu_order' => 13,
                'menu_parent' => 0,
            ],
            // Additional settings menus
            [
                'menu_name' => 'Email & Notification',
                'menu_slug' => 'email-notification',
                'menu_icon' => 'fa-bell',
                'menu_url' => null,
                'menu_permission' => 'settings-notification',
                'menu_order' => 14,
                'menu_parent' => 0,
            ],
        ];

        // Insert parent menus first and collect their IDs
        $parentIdMap = [];
        $orderCounter = 1;

        foreach ($parentMenus as $parent) {
            $parent['menu_order'] = $orderCounter++;
            $parentId = DB::table('menus')->insertGetId(array_merge($parent, [
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
            $parentIdMap[$parent['menu_name']] = $parentId;
        }

        // Now insert child menus with correct parent IDs
        $childMenus = [
            // Driver Management children
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
                'menu_icon' => 'fa-circle-plus',
                'menu_url' => 'drivers.create',
                'menu_permission' => 'driver-create',
                'menu_order' => 2,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Driver Documents',
                'menu_slug' => 'driver-documents',
                'menu_icon' => 'fa-file',
                'menu_url' => 'driver-documents.index',
                'menu_permission' => 'driver-document-manage',
                'menu_order' => 3,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Driver Performance',
                'menu_slug' => 'driver-performance',
                'menu_icon' => 'fa-chart-simple',
                'menu_url' => 'driver_performance',
                'menu_permission' => 'driver-performance-view',
                'menu_order' => 4,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'License Type',
                'menu_slug' => 'license-type-manage',
                'menu_icon' => 'fa-id-card',
                'menu_url' => 'license-types.index',
                'menu_permission' => 'license-type-manage',
                'menu_order' => 5,
                'parent_name' => 'Driver Management',
            ],
            // Driver Personal Module (for drivers accessing their own data)
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
                'menu_icon' => 'fa-calendar',
                'menu_url' => 'driver.schedule',
                'menu_permission' => 'driver-access',
                'menu_order' => 7,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'My Trips',
                'menu_slug' => 'driver-trips',
                'menu_icon' => 'fa-road',
                'menu_url' => 'driver.trips',
                'menu_permission' => 'driver-access',
                'menu_order' => 8,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Trip Status',
                'menu_slug' => 'driver-trip-status',
                'menu_icon' => 'fa-exchange-alt',
                'menu_url' => 'driver.trip.status',
                'menu_permission' => 'driver-access',
                'menu_order' => 9,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Fuel Log',
                'menu_slug' => 'driver-fuel-log',
                'menu_icon' => 'fa-gas-pump',
                'menu_url' => 'driver.fuel.log',
                'menu_permission' => 'driver-access',
                'menu_order' => 10,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'My Availability',
                'menu_slug' => 'driver-availability',
                'menu_icon' => 'fa-clock',
                'menu_url' => 'driver.availability',
                'menu_permission' => 'driver-access',
                'menu_order' => 11,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'My Vehicle',
                'menu_slug' => 'driver-vehicle',
                'menu_icon' => 'fa-truck',
                'menu_url' => 'driver.vehicle',
                'menu_permission' => 'driver-access',
                'menu_order' => 12,
                'parent_name' => 'Driver Management',
            ],

            // Vehicle Management children
            [
                'menu_name' => 'Vehicle List',
                'menu_slug' => 'vehicle-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'vehicles.index',
                'menu_permission' => 'vehicle-manage',
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
                'menu_name' => 'Vendor List',
                'menu_slug' => 'vendor-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'vendors.index',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 3,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Add Vendor',
                'menu_slug' => 'add-vendor',
                'menu_icon' => 'fa-plus',
                'menu_url' => 'vendors.create',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 4,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Vehicle Type List',
                'menu_slug' => 'vehicle-type-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'vehicle-type.index',
                'menu_permission' => 'vehicle-manage',
                'menu_order' => 5,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Add Vehicle Type',
                'menu_slug' => 'add-vehicle-type',
                'menu_icon' => 'fa-plus',
                'menu_url' => 'vehicle-type.create',
                'menu_permission' => 'vehicle-manage',
                'menu_order' => 6,
                'parent_name' => 'Vehicle Management',
            ],

            // Vehicle Maintenance children
            [
                'menu_name' => 'Maintenance Requests',
                'menu_slug' => 'maintenance-requests',
                'menu_icon' => 'fa-inbox',
                'menu_url' => 'maintenance.index',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 1,
                'parent_name' => 'Vehicle Maintenance',
            ],
            [
                'menu_name' => 'Maintenance Type',
                'menu_slug' => 'menu.maintenance-type',
                'menu_icon' => 'fa-tag',
                'menu_url' => 'maintenance-types.index',
                'menu_permission' => 'maintenance-type-manage',
                'menu_order' => 2,
                'parent_name' => 'Vehicle Maintenance',
            ],
            [
                'menu_name' => 'Maintenance Vendor',
                'menu_slug' => 'menu.maintenance-vendor',
                'menu_icon' => 'fa-building',
                'menu_url' => 'maintenance-vendors.index',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 3,
                'parent_name' => 'Vehicle Maintenance',
            ],
            [
                'menu_name' => 'Maintenance Category',
                'menu_slug' => 'menu.maintenance-category',
                'menu_icon' => 'fa-tags',
                'menu_url' => 'maintenance-categories.index',
                'menu_permission' => 'maintenance-category-manage',
                'menu_order' => 4,
                'parent_name' => 'Vehicle Maintenance',
            ],
            [
                'menu_name' => 'Maintenance History',
                'menu_slug' => 'maintenance-history',
                'menu_icon' => 'fa-clock-rotate-left',
                'menu_url' => 'admin-maintenance.history',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 5,
                'parent_name' => 'Vehicle Maintenance',
            ],

            // Vehicle Requisition children
            [
                'menu_name' => 'Add Requisition',
                'menu_slug' => 'requisition-create',
                'menu_icon' => 'fa-file-o',
                'menu_url' => 'requisitions.create',
                'menu_permission' => 'requisition-create',
                'menu_order' => 1,
                'parent_name' => 'Vehicle Requisition',
            ],
            [
                'menu_name' => 'My Requisitions',
                'menu_slug' => 'requisition-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'requisitions.index',
                'menu_permission' => 'requisition-view',
                'menu_order' => 2,
                'parent_name' => 'Vehicle Requisition',
            ],

            // Approvals children
            [
                'menu_name' => 'Pending Department Approvals',
                'menu_slug' => 'department-approvals',
                'menu_icon' => 'fa-building',
                'menu_url' => 'department.approvals.index',
                'menu_permission' => 'department-approval-view',
                'menu_order' => 1,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Pending Transport Approvals',
                'menu_slug' => 'transport-approvals',
                'menu_icon' => 'fa-truck-fast',
                'menu_url' => 'transport.approvals.index',
                'menu_permission' => 'transport-approval-view',
                'menu_order' => 2,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Pending Maintenance Approvals',
                'menu_slug' => 'maintenance-pending-approvals',
                'menu_icon' => 'fa-wrench',
                'menu_url' => 'maintenance_approvals.index',
                'menu_permission' => 'maintenance-approval-view',
                'menu_order' => 3,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Approved Maintenance',
                'menu_slug' => 'maintenance-approved',
                'menu_icon' => 'fa-check',
                'menu_url' => 'maintenance_approvals.approved',
                'menu_permission' => 'maintenance-approval-view',
                'menu_order' => 4,
                'parent_name' => 'Approvals',
            ],

            // Trip Sheets children
            [
                'menu_name' => 'All Trips',
                'menu_slug' => 'all-trips',
                'menu_icon' => 'fa-list',
                'menu_url' => 'trip-sheets.index',
                'menu_permission' => 'trip-manage',
                'menu_order' => 1,
                'parent_name' => 'Trip Sheets',
            ],
            [
                'menu_name' => 'Active Trips',
                'menu_slug' => 'active-trips',
                'menu_icon' => 'fa-clock',
                'menu_url' => 'trip-sheets.active',
                'menu_permission' => 'trip-manage',
                'menu_order' => 2,
                'parent_name' => 'Trip Sheets',
            ],
            [
                'menu_name' => 'Completed Trips',
                'menu_slug' => 'completed-trips',
                'menu_icon' => 'fa-circle-check',
                'menu_url' => 'trip-sheets.completed',
                'menu_permission' => 'trip-manage',
                'menu_order' => 3,
                'parent_name' => 'Trip Sheets',
            ],

            // Employee Manage children
            [
                'menu_name' => 'Manage Employees',
                'menu_slug' => 'menu.employee.list',
                'menu_icon' => 'fa-rectangle-list',
                'menu_url' => 'admin.employees.index',
                'menu_permission' => 'employee-manage',
                'menu_order' => 1,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Unit Manage',
                'menu_slug' => 'unit-manage',
                'menu_icon' => 'fa-building',
                'menu_url' => 'admin.units.index',
                'menu_permission' => 'unit-manage',
                'menu_order' => 2,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Company List',
                'menu_slug' => 'company-list',
                'menu_icon' => 'fa-building',
                'menu_url' => 'admin.company.index',
                'menu_permission' => 'company-manage',
                'menu_order' => 3,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Location Manage',
                'menu_slug' => 'location-manage',
                'menu_icon' => 'fa-location-dot',
                'menu_url' => 'admin.locations.index',
                'menu_permission' => 'location-manage',
                'menu_order' => 4,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Departments',
                'menu_slug' => 'menu.department',
                'menu_icon' => 'fa-briefcase',
                'menu_url' => 'admin.departments.index',
                'menu_permission' => 'department-manage',
                'menu_order' => 5,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Department Heads',
                'menu_slug' => 'menu.department-heads',
                'menu_icon' => 'fa-user-tie',
                'menu_url' => 'admin.department-heads.index',
                'menu_permission' => 'department-head-manage',
                'menu_order' => 6,
                'parent_name' => 'Employee Manage',
            ],

            // Reports children
            [
                'menu_name' => 'Requisition Report',
                'menu_slug' => 'requisition-report',
                'menu_icon' => 'fa-clipboard',
                'menu_url' => 'admin.reports.requisitions',
                'menu_permission' => 'report-requisition',
                'menu_order' => 1,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Trip & Fuel Consumption Report',
                'menu_slug' => 'Trip-Fuel-Consumption-Report',
                'menu_icon' => 'fa-road',
                'menu_url' => 'reports.trips_fuel',
                'menu_permission' => 'report-trip-fuel',
                'menu_order' => 2,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Vehicle Utilization Report',
                'menu_slug' => 'Vehicle-Utilization-Report',
                'menu_icon' => 'fa-truck',
                'menu_url' => 'reports.vehicle_utilization',
                'menu_permission' => 'report-vehicle-utilization',
                'menu_order' => 3,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Driver Performance Report',
                'menu_slug' => 'Driver-Performance-Report',
                'menu_icon' => 'fa-id-card',
                'menu_url' => 'reports.driver_performance',
                'menu_permission' => 'report-driver-performance',
                'menu_order' => 4,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Maintenance Reports',
                'menu_slug' => 'Maintenance-Reports',
                'menu_icon' => 'fa-cogs',
                'menu_url' => 'reports.maintenance',
                'menu_permission' => 'report-maintenance',
                'menu_order' => 5,
                'parent_name' => 'Reports',
            ],

            // User Manage children
            [
                'menu_name' => 'Add User',
                'menu_slug' => 'add-user',
                'menu_icon' => 'fa-circle-plus',
                'menu_url' => 'users.create',
                'menu_permission' => 'user-create',
                'menu_order' => 1,
                'parent_name' => 'User Manage',
            ],
            [
                'menu_name' => 'User List',
                'menu_slug' => 'user-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'users.index',
                'menu_permission' => 'user-manage',
                'menu_order' => 2,
                'parent_name' => 'User Manage',
            ],

            // Menu Manage children
            [
                'menu_name' => 'Add Menu',
                'menu_slug' => 'add-menu',
                'menu_icon' => 'fa-square-plus',
                'menu_url' => 'menus.create',
                'menu_permission' => 'menu-manage',
                'menu_order' => 1,
                'parent_name' => 'Menu Manage',
            ],
            [
                'menu_name' => 'Menu List',
                'menu_slug' => 'menu-list',
                'menu_icon' => 'fa-list-ul',
                'menu_url' => 'menus.index',
                'menu_permission' => 'menu-manage',
                'menu_order' => 2,
                'parent_name' => 'Menu Manage',
            ],

            // Email & Notification Settings children
            [
                'menu_name' => 'Notification Settings',
                'menu_slug' => 'notification-settings',
                'menu_icon' => 'fa-gear',
                'menu_url' => 'settings.notifications',
                'menu_permission' => 'settings-notification',
                'menu_order' => 1,
                'parent_name' => 'Email & Notification',
            ],
            [
                'menu_name' => 'Push Subscribers',
                'menu_slug' => 'push-subscribers',
                'menu_icon' => 'fa-rss',
                'menu_url' => 'admin.push.subscribers',
                'menu_permission' => 'notification-manage',
                'menu_order' => 2,
                'parent_name' => 'Email & Notification',
            ],
            [
                'menu_name' => 'Email Templates',
                'menu_slug' => 'email-templates',
                'menu_icon' => 'fa-envelope',
                'menu_url' => 'email-templates.index',
                'menu_permission' => 'email-template-manage',
                'menu_order' => 3,
                'parent_name' => 'Email & Notification',
            ],
            [
                'menu_name' => 'Email Log History',
                'menu_slug' => 'email-log-history',
                'menu_icon' => 'fa-clock-rotate-left',
                'menu_url' => 'emaillogs.index',
                'menu_permission' => 'emaillog-manage',
                'menu_order' => 4,
                'parent_name' => 'Email & Notification',
            ],
        ];

        // Insert child menus with correct parent_id and sequential ordering
        $childOrderCounters = [];
        
        foreach ($childMenus as $child) {
            $parentName = $child['parent_name'];
            
            // Initialize counter for this parent if not exists
            if (!isset($childOrderCounters[$parentName])) {
                $childOrderCounters[$parentName] = 1;
            }
            
            $parentId = $parentIdMap[$parentName] ?? 0;
            DB::table('menus')->insert([
                'menu_name' => $child['menu_name'],
                'menu_slug' => $child['menu_slug'],
                'menu_icon' => $child['menu_icon'],
                'menu_url' => $child['menu_url'],
                'menu_permission' => $child['menu_permission'],
                'menu_order' => $childOrderCounters[$parentName]++,
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

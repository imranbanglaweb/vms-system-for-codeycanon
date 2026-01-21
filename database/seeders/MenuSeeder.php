<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('menus')->truncate();
        Schema::enableForeignKeyConstraints();

        $adminId = 1;
        $now = Carbon::now();

        $menus = [

        

                    /* ================= DASHBOARD ================= */

                    [

                        'menu_name' => 'Dashboard',

                        'menu_slug' => 'menu.dashboard',

                        'menu_icon' => 'fa-tachometer',

                        'menu_url' => 'home',

                        'menu_permission' => 'dashboard',

                        'menu_order' => 1,

                        'menu_parent' => 0,

                    ],

                      /* ================= SETTINGS ================= */

                    [

                        'menu_name' => 'Settings',

                        'menu_slug' => 'menu.settings',

                        'menu_icon' => 'fa-cogs',

                        'menu_url' => 'settings.index',

                        'menu_permission' => 'settings.manage',

                        'menu_order' => 2,

                        'menu_parent' => 0,

                    ],

                       /* ================= Roles & Permissions ================= */

                    [

                        'menu_name' => 'Roles & Permissions',

                        'menu_slug' => 'Role-Permission-Manage',

                        'menu_icon' => 'fa-shield',

                        'menu_url' => 'roles.index',

                        'menu_permission' => 'role.manage',

                        'menu_order' => 3,

                        'menu_parent' => 0,

                    ],

                        /* ================= Users ================= */

                    [

                        'menu_name' => 'User Manage',

                        'menu_slug' => 'User-Manage',

                        'menu_icon' => 'fa-users',

                        'menu_url' => null,

                        'menu_permission' => 'user.manage',

                        'menu_order' => 4,

                        'menu_parent' => 0,

                    ],

                      [

                        'menu_name' => 'Add User',

                        'menu_slug' => 'add-user',

                        'menu_icon' => 'fa-plus-circle',

                        'menu_url' => 'users.create',

                        'menu_permission' => 'user.create',

                        'menu_order' => 4,

                        'menu_parent' => 4,

                    ],

                      [

                        'menu_name' => 'User List',

                        'menu_slug' => 'user-list',

                        'menu_icon' => 'fa-list',

                        'menu_url' => 'users.index',

                        'menu_permission' => 'user.manage',

                        'menu_order' => 4,

                        'menu_parent' => 4,

                    ],

                    

                       /* ================= Menu Permission ================= */

                     [

                        'menu_name' => 'Menu Manage',

                        'menu_slug' => 'menu-Manage',

                        'menu_icon' => 'fa-sitemap',

                        'menu_url'  => null,

                        'menu_permission' => 'menu.manage',

                        'menu_order' => 7,

                        'menu_parent' => 0,

                    ],

                    [

                        'menu_name' => 'Add Menu',

                        'menu_slug' => 'add-menu',

                        'menu_icon' => 'fa-plus-square-o',

                        'menu_url' => null,

                        'menu_permission' => 'menu.create',

                        'menu_order' => 8,

                        'menu_parent' => 7,

                    ],

                       [

                        'menu_name' => 'Menu List',

                        'menu_slug' => 'menu-list',

                        'menu_icon' => 'fa-list-ul',

                        'menu_url' => 'menus.index',

                        'menu_permission' => 'menu.manage',

                        'menu_order' => 9,

                        'menu_parent' => 7,

                    ],

        

                      /* ================= EMPLOYEE MANAGEMENT ================= */

                    [

                                                'menu_name' => 'Employee Manage',

                                                'menu_slug' => 'menu.employee',

                                                'menu_icon' => 'fas fa-users',

                        'menu_url' => null,

                        'menu_permission' => 'employee.manage',

                        'menu_order' => 10,

                        'menu_parent' => 0,

                    ],

                    [

                        'menu_name' => 'Manage Employees',

                        'menu_slug' => 'menu.employee.list',

                        'menu_icon' => 'fa fa-list-alt',

                        'menu_url' => 'employees.index',

                        'menu_permission' => 'employee.manage',

                        'menu_order' => 11,

                        'menu_parent' => 10,

                    ],

                    [

                        'menu_name' => 'Unit Manage',

                        'menu_slug' => 'unit-manage',

                        'menu_icon' => 'fa-building-o',

                        'menu_url' => 'units.index',

                        'menu_permission' => 'unit.manage',

                        'menu_order' => 12,

                        'menu_parent' => 10,

                    ],

                    [

                        'menu_name' => 'Location Manage',

                        'menu_slug' => 'location-manage',

                        'menu_icon' => 'fa-map-marker',

                        'menu_url' => 'locations.index',

                        'menu_permission' => 'location.manage',

                        'menu_order' => 13,

                        'menu_parent' => 10,

                    ],

                    [

                        'menu_name' => 'Departments',

                        'menu_slug' => 'menu.department',

                        'menu_icon' => 'fa-briefcase',

                        'menu_url' => 'departments.index',

                        'menu_permission' => 'department.manage',

                        'menu_order' => 14,

                        'menu_parent' => 10,

                    ],

                    

                    [

                        'menu_name' => 'License Type Manage',

                        'menu_slug' => 'license-type-manage',

                        'menu_icon' => 'fa-certificate',

                        'menu_url' => 'license-types.index',

                        'menu_permission' => 'driver.manage',

                        'menu_order' => 15,

                        'menu_parent' => 10,

                    ],

                                /* ================= DRIVER MANAGEMENT ================= */

                    [

                        'menu_name' => 'Driver Manage',

                        'menu_slug' => 'driver-manage',

                        'menu_icon' => 'fa-car',

                        'menu_url' => 'drivers.index',

                        'menu_permission' => 'driver.manage',

                        'menu_order' => 16,

                        'menu_parent' => 0,

                    ],

                                /* ================= VEHICLE MANAGEMENT ================= */

                    [

                        'menu_name' => 'Vehicle Management',

                        'menu_slug' => 'vehicle-managemant',

                        'menu_icon' => 'fa-truck',

                        'menu_url' => null,

                        'menu_permission' => 'vehicle.manage',

                        'menu_order' => 17,

                        'menu_parent' => 0,

                    ],

                    [

                        'menu_name' => 'Vehicle List',

                        'menu_slug' => 'vehicle-list',

                        'menu_icon' => 'fa-list',

                        'menu_url' => 'vehicles.index',

                        'menu_permission' => 'vehicle.manage',

                        'menu_order' => 18,

                        'menu_parent' => 17,

                    ],

                    

                    [

                        'menu_name' => 'Add Vehicle',

                        'menu_slug' => 'add-vehicle',

                        'menu_icon' => 'fa-plus',

                        'menu_url' => 'vehicles.create',

                        'menu_permission' => 'vehicle.create',

                        'menu_order' => 19,

                        'menu_parent' => 17,

                    ],

                    [

                        'menu_name' => 'Vendor Manage',

                        'menu_slug' => 'vendor-manage',

                        'menu_icon' => 'fa-book',

                        'menu_url' => 'vendors.index',

                        'menu_permission' => 'maintenance.vendor.manage',

                        'menu_order' => 20,

                        'menu_parent' => 17,

                    ],

                    [

                        'menu_name' => 'Vehicle Type Manage',

                        'menu_slug' => 'vehicle-type-manage',

                        'menu_icon' => 'fa-tags',

                        'menu_url' => 'vehicle-type.index',

                        'menu_permission' => 'vehicle.manage',

                        'menu_order' => 21,

                        'menu_parent' => 17,

                    ],

        

                       /* ================= VEHICLE  MAINTENANCE ================= */

                    [

                        'menu_name' => 'Vehicle Maintenance',

                        'menu_slug' => 'menu.maintenance',

                        'menu_icon' => 'fa-wrench',

                        'menu_url' => null,

                        'menu_permission' => 'maintenance.manage',

                        'menu_order' => 22,

                        'menu_parent' => 0,

                    ],

                    [

                        'menu_name' => 'Maintenance Requests',

                        'menu_slug' => 'menu.maintenance.request',

                        'menu_icon' => 'fa-inbox',

                        'menu_url' => 'maintenance.index',

                        'menu_permission' => 'maintenance.manage',

                        'menu_order' => 23,

                        'menu_parent' => 22,

                    ],

                      [

                        'menu_name' => 'Maintenance Type',

                        'menu_slug' => 'menu.maintenance-type',

                        'menu_icon' => 'fa-tag',

                        'menu_url' => 'maintenance-types.index',

                        'menu_permission' => 'maintenance.type.manage',

                        'menu_order' => 24,

                        'menu_parent' => 22,

                    ],

                    [

                        'menu_name' => 'Maintenance History',

                        'menu_slug' => 'menu.maintenance.history',

                        'menu_icon' => 'fa-history',

                        'menu_url' => 'maintenance.history',

                        'menu_permission' => 'maintenance.manage',

                        'menu_order' => 25,

                        'menu_parent' => 22,

                    ],

                    

                    [

                        'menu_name' => 'Maintenance Vendor',

                        'menu_slug' => 'menu.maintenance-vendor',

                        'menu_icon' => 'fa-building',

                        'menu_url' => 'maintenance-vendors.index',

                        'menu_permission' => 'maintenance.vendor.manage',

                        'menu_order' => 26,

                        'menu_parent' => 22,

                    ],

                    

                    [

                        'menu_name' => 'Maintenance Category',

                        'menu_slug' => 'menu.maintenance-category',

                        'menu_icon' => 'fa-tags',

                        'menu_url' => 'maintenance-categories.index',

                        'menu_permission' => 'maintenance.category.manage',

                        'menu_order' => 27,

                        'menu_parent' => 22,

                    ],

        

                    /* ================= VEHICLE REQUISITION ================= */

                    [

                        'menu_name' => 'Vehicle Requisition',

                        'menu_slug' => 'vehicle-requisition',

                        'menu_icon' => 'fa-file-text-o',

                        'menu_url' => null,

                        'menu_permission' => 'requisition.view',

                        'menu_order' => 28,

                        'menu_parent' => 0,

                    ],

                    [

                        'menu_name' => 'Add Requisition',

                        'menu_slug' => 'requisition-create',

                        'menu_icon' => 'fa-file-o',

                        'menu_url' => 'requisitions.create',

                        'menu_permission' => 'requisition.create',

                        'menu_order' => 29,

                        'menu_parent' => 28,

                    ],

                    [

                        'menu_name' => 'My Requisitions',

                        'menu_slug' => 'requisition-list',

                        'menu_icon' => 'fa-list',

                        'menu_url' => 'requisitions.index',

                        'menu_permission' => 'requisition.view',

                        'menu_order' => 30,

                        'menu_parent' => 28,

                    ],

                    [

                        'menu_name' => 'Approval',

                        'menu_slug' => 'approval',

                        'menu_icon' => 'fa-gavel',

                        'menu_url' => null,

                        'menu_permission' => 'requisition.approve',

                        'menu_order' => 31,

                        'menu_parent' => 0,

                    ],

                    [

                        'menu_name' => 'Pending Approval',

                        'menu_slug' => 'requisition-pending',

                        'menu_icon' => 'fa-clock-o',

                        'menu_url' => 'requisitions.pending',

                        'menu_permission' => 'requisition.approve',

                        'menu_order' => 32,

                        'menu_parent' => 31,

                    ],

                    [

                        'menu_name' => 'Approved Requisitions',

                        'menu_slug' => 'requisition.approved',

                        'menu_icon' => 'fa-check-square-o',

                        'menu_url'  => 'requisitions.approved',

                        'menu_permission' => 'requisition.view',

                        'menu_order' => 33,

                        'menu_parent' => 31,

                    ],

        

                     /* ================= TRIP SHEETS ================= */

                    [

                        'menu_name' => 'Trip Sheets',

                        'menu_slug' => 'trip-sheets',

                        'menu_icon' => 'fa-road',

                        'menu_url' => 'trip-sheets.index',

                        'menu_permission' => 'trip.manage',

                        'menu_order' => 34,

                        'menu_parent' => 0,

                    ],

        

        

                        /* ================= SUBSCRIPTION PLAN ================= */

                        [

                            'menu_name' => 'Subscription Plan',

                            'menu_slug' => 'subscription-plan',

                            'menu_icon' => 'fa-usd',

                            'menu_url' => 'admin.plans.index',

                            'menu_permission' => 'subscription.plan.manage',

                            'menu_order' => 35,

                            'menu_parent' => 0,

                        ],

        

                        /* ================= SAAS MANAGEMENT ================= */

                        [

                            'menu_name' => 'SaaS Management',

                            'menu_slug' => 'saas-management',

                            'menu_icon' => 'fa-cloud',

                            'menu_url' => null,

                            'menu_permission' => 'subscription.approve',

                            'menu_order' => 36,

                            'menu_parent' => 0,

                        ],

                        [

                            'menu_name' => 'Subscriptions',

                            'menu_slug' => 'subscriptions',

                            'menu_icon' => 'fa-refresh',

                            'menu_url' => 'admin.subscriptions.index',

                            'menu_permission' => 'subscription.approve',

                            'menu_order' => 37,

                            'menu_parent' => 36,

                        ],

        

                        // pending paymenyts

                        [

                            'menu_name' => 'Pending Payments',

                            'menu_slug' => 'pending-payments',

                            'menu_icon' => 'fa-clock-o',

                            'menu_url' => 'admin.payments.pending',

                            'menu_permission' => 'payment.approve',

                            'menu_order' => 38,

                            'menu_parent' => 36,

                        ],  

                        // paid payments

                        [

                            'menu_name' => 'Approved Payments',

                            'menu_slug' => 'approved-payments',

                            'menu_icon' => 'fa-money',

                            'menu_url' => 'admin.payments.approved',

                            'menu_permission' => 'payment.view',

                            'menu_order' => 39,

                            'menu_parent' => 36,

                        ],  

                        // rejected payments

                        [

                            'menu_name' => 'Rejected Payments',

                            'menu_slug' => 'rejected-payments',

                            'menu_icon' => 'fa-thumbs-down',

                            'menu_url' => 'admin.payments.rejected',

                            'menu_permission' => 'payment.view',

                            'menu_order' => 40,

                            'menu_parent' => 36,

                        ],

        

        

                    /* ================= REPORTS ================= */

                    [

                        'menu_name' => 'Reports',

                        'menu_slug' => 'menu.reports',

                        'menu_icon' => 'fa fa-file-text',

                        'menu_url' => null,

                        'menu_permission' => 'report.requisition',

                        'menu_order' => 41,

                        'menu_parent' => 0,

                    ],

                    [

                        'menu_name' => 'Requisition Report',

                        'menu_slug' => 'menu.report.requisition',

                        'menu_icon' => 'fa-file-text-o',

                        'menu_url' => 'reports.requisitions',

                        'menu_permission' => 'report.requisition',

                        'menu_order' => 42,

                        'menu_parent' => 41,

                    ],

                     [
                        'menu_name' => 'Trip & Fuel Consumption Report',
                        'menu_slug' => 'Trip-Fuel-Consumption-Report',
                        'menu_icon' => 'fa-truck',
                        'menu_url' => 'trips_fuel.index',
                        'menu_permission' => 'report-trip.fuel',
                        'menu_order' => 43,
                        'menu_parent' => 41,
                    ],

                    [
                        'menu_name' => 'Vehicle Utilization Report',
                        'menu_slug' => 'Vehicle-Utilization-Report',
                        'menu_icon' => 'fa-truck',
                        'menu_url' => 'vehicle_utilization.index',
                        'menu_permission' => 'report-vehicle-utilization',
                        'menu_order' => 44,
                        'menu_parent' => 41,
                    ],
                    
                    [
                        'menu_name' => 'Driver Performance Report',
                        'menu_slug' => 'Driver-Performance-Report',
                        'menu_icon' => 'fa-truck',
                        'menu_url' => 'driver_performance.index',
                        'menu_permission' => 'report-driver-performance',
                        'menu_order' => 45,
                        'menu_parent' => 41,
                    ],
                    
                    [
                        'menu_name' => 'Maintenance Reports',
                        'menu_slug' => 'Maintenance-Reports',
                        'menu_icon' => 'fa-truck',
                        'menu_url' => 'maintenance.index',
                        'menu_permission' => 'report-maintenance',
                        'menu_order' => 46,
                        'menu_parent' => 41,
                    ],
                

                      /* ================= Email & Notification Settings ================= */

        

                    [

                        'menu_name' => 'Email & Notification Settings',

                        'menu_slug' => 'email-notification',

                        'menu_icon' => 'fa-envelope-o',

                        'menu_url' => null,

                        'menu_permission' => 'settings.notification',

                        'menu_order' => 47,

                        'menu_parent' => 0,

                    ],

                    // settings/notifications

                    [

                        'menu_name' => 'Notification Settings',

                        'menu_slug' => 'notification-settings',

                        'menu_icon' => 'fa-bell',

                        'menu_url' => 'settings.notifications',

                        'menu_permission' => 'settings.notification',

                        'menu_order' => 48,

                        'menu_parent' => 47,

                    ],

                    // admin/push-subscribers

                    [

                        'menu_name' => 'Push Subscribers',

                        'menu_slug' => 'push-subscribers',

                        'menu_icon' => 'fas fa-bell',

                        'menu_url' => 'admin.push.subscribers',

                        'menu_permission' => 'notification.manage',

                        'menu_order' => 49,

                        'menu_parent' => 47,

                    ],

                ];

        foreach ($menus as $menu) {
            DB::table('menus')->insert(array_merge($menu, [
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}

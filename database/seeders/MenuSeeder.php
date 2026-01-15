<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    public function run()
    {
        DB::table('menus')->truncate();

        $adminId = 1;
        $now = Carbon::now();

        $menus = [

            /* ================= DASHBOARD ================= */
            [
                'menu_name' => 'Dashboard',
                'menu_slug' => 'menu.dashboard',
                'menu_icon' => 'fa-dashboard',
                'menu_url' => 'home',
                'menu_permission' => 'dashboard',
                'menu_order' => 1,
                'menu_parent' => 0,
            ],
              /* ================= SETTINGS ================= */
            [
                'menu_name' => 'Settings',
                'menu_slug' => 'menu.settings',
                'menu_icon' => 'fa-cog',
                'menu_url' => 'settings.index',
                'menu_permission' => 'settings.manage',
                'menu_order' => 2,
                'menu_parent' => 0,
            ],
               /* ================= Roles & Permissions ================= */
            [
                'menu_name' => 'Roles & Permissions',
                'menu_slug' => 'menu.roles',
                'menu_icon' => 'fa-lock',
                'menu_url' => 'roles.index',
                'menu_permission' => 'role.manage',
                'menu_order' => 3,
                'menu_parent' => 0,
            ],
                /* ================= Users ================= */
            [
                'menu_name' => 'User Management',
                'menu_slug' => 'menu.users',
                'menu_icon' => 'fa-user',
                'menu_url' => 'users.index',
                'menu_permission' => 'user.manage',
                'menu_order' => 4,
                'menu_parent' => 0,
            ],

               /* ================= Menu Permission ================= */
             [
                'menu_name' => 'Menu Management',
                'menu_slug' => 'menu-managemant',
                'menu_icon' => 'fa-bars',
                'menu_url' => null,
                'menu_permission' => 'menu-managemant',
                'menu_order' => 5,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Add Menu',
                'menu_slug' => 'add-menu',
                'menu_icon' => 'fa-plus',
                'menu_url' => null,
                'menu_permission' => 'menu-create',
                'menu_order' => 5,
                'menu_parent' => 5,
            ],
               [
                'menu_name' => 'Menu List',
                'menu_slug' => 'menu-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'menus.index',
                'menu_permission' => 'menu-index',
                'menu_order' => 5,
                'menu_parent' => 5,
            ],

              /* ================= EMPLOYEE MANAGEMENT ================= */
            [
                'menu_name' => 'Employee Management',
                'menu_slug' => 'menu.employee',
                'menu_icon' => 'fa-users',
                'menu_url' => null,
                'menu_permission' => 'employee.manage',
                'menu_order' => 6,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Employees',
                'menu_slug' => 'menu.employee.list',
                'menu_icon' => 'fa-user',
                'menu_url' => 'employees.index',
                'menu_permission' => 'employee.manage',
                'menu_order' => 1,
                'menu_parent' => 6,
            ],
            [
                'menu_name' => 'Departments',
                'menu_slug' => 'menu.department',
                'menu_icon' => 'fa-building',
                'menu_url' => 'departments.index',
                'menu_permission' => 'department.manage',
                'menu_order' => 2,
                'menu_parent' => 6,
            ],

            /* ================= VEHICLE REQUISITION ================= */
            [
                'menu_name' => 'Vehicle Requisition',
                'menu_slug' => 'vehicle-requisition',
                'menu_icon' => 'fa-file-text',
                'menu_url' => null,
                'menu_permission' => 'vehicle-requisition',
                'menu_order' => 6,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Add Requisition',
                'menu_slug' => 'requisition-create',
                'menu_icon' => 'fa-plus',
                'menu_url' => 'requisitions.create',
                'menu_permission' => 'requisition.create',
                'menu_order' => 6,
                'menu_parent' => 6,
            ],
            [
                'menu_name' => 'My Requisitions',
                'menu_slug' => 'requisition-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'requisitions.index',
                'menu_permission' => 'requisition.list',
                'menu_order' => 6,
                'menu_parent' => 6,
            ],
            [
                'menu_name' => 'Approval',
                'menu_slug' => 'approval',
                'menu_icon' => 'fa-clock-o',
                'menu_url' => null,
                'menu_permission' => 'requisition.approve',
                'menu_order' => 7,
                'menu_parent' => 7,
            ],
            [
                'menu_name' => 'Pending Approval',
                'menu_slug' => 'requisition-pending',
                'menu_icon' => 'fa-clock-o',
                'menu_url' => 'requisitions.pending',
                'menu_permission' => 'requisition.approve',
                'menu_order' => 7,
                'menu_parent' => 7,
            ],
            [
                'menu_name' => 'Approved Requisitions',
                'menu_slug' => 'requisition.approved',
                'menu_icon' => 'fa-check',
                'menu_url'  => 'requisitions.approved',
                'menu_permission' => 'requisition.view',
                'menu_order' => 7,
                'menu_parent' => 7,
            ],

            /* ================= VEHICLE MANAGEMENT ================= */
            [
                'menu_name' => 'Vehicle Management',
                'menu_slug' => 'vehicle-managemant',
                'menu_icon' => 'fa-truck',
                'menu_url' => null,
                'menu_permission' => 'vehicle.manage',
                'menu_order' => 8,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Vehicles',
                'menu_slug' => 'menu.vehicle.list',
                'menu_icon' => 'fa-car',
                'menu_url' => 'vehicles.index',
                'menu_permission' => 'vehicle.manage',
                'menu_order' => 8,
                'menu_parent' => 8,
            ],
            [
                'menu_name' => 'Vehicle Types',
                'menu_slug' => 'menu.vehicle.type',
                'menu_icon' => 'fa-tags',
                'menu_url' => 'vehicle-types.index',
                'menu_permission' => 'vehicle.manage',
                'menu_order' => 8,
                'menu_parent' => 8,
            ],
            [
                'menu_name' => 'Fuel Types',
                'menu_slug' => 'menu.fuel.type',
                'menu_icon' => 'fa-tint',
                'menu_url' => 'fuel-types.index',
                'menu_permission' => 'vehicle.manage',
                'menu_order' => 8,
                'menu_parent' => 8,
            ],

            /* ================= DRIVER MANAGEMENT ================= */
            [
                'menu_name' => 'Driver Management',
                'menu_slug' => 'menu.driver',
                'menu_icon' => 'fa-id-card',
                'menu_url' => null,
                'menu_permission' => 'driver.manage',
                'menu_order' => 9,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Drivers',
                'menu_slug' => 'menu.driver.list',
                'menu_icon' => 'fa-user',
                'menu_url' => 'drivers.index',
                'menu_permission' => 'driver.manage',
                'menu_order' => 9,
                'menu_parent' => 9,
            ],
            [
                'menu_name' => 'Driver Assignments',
                'menu_slug' => 'menu.driver.assign',
                'menu_icon' => 'fa-random',
                'menu_url' => 'driver-assignments.index',
                'menu_permission' => 'driver.manage',
                'menu_order' => 9,
                'menu_parent' => 9,
            ],

          

            /* ================= MAINTENANCE ================= */
            [
                'menu_name' => 'Vehicle Maintenance',
                'menu_slug' => 'menu.maintenance',
                'menu_icon' => 'fa-wrench',
                'menu_url' => null,
                'menu_permission' => 'maintenance.manage',
                'menu_order' => 12,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Maintenance Requests',
                'menu_slug' => 'menu.maintenance.request',
                'menu_icon' => 'fa-tools',
                'menu_url' => 'maintenance.index',
                'menu_permission' => 'maintenance.manage',
                'menu_order' => 1,
                'menu_parent' => 12,
            ],
            [
                'menu_name' => 'Maintenance History',
                'menu_slug' => 'menu.maintenance.history',
                'menu_icon' => 'fa-history',
                'menu_url' => 'maintenance.history',
                'menu_permission' => 'maintenance.manage',
                'menu_order' => 2,
                'menu_parent' => 12,
            ],

            /* ================= REPORTS ================= */
            [
                'menu_name' => 'Reports',
                'menu_slug' => 'menu.reports',
                'menu_icon' => 'fa-bar-chart',
                'menu_url' => null,
                'menu_permission' => 'report.view',
                'menu_order' => 13,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Requisition Report',
                'menu_slug' => 'menu.report.requisition',
                'menu_icon' => 'fa-file',
                'menu_url' => 'reports.requisitions',
                'menu_permission' => 'report.view',
                'menu_order' => 1,
                'menu_parent' => 13,
            ],
            [
                'menu_name' => 'Vehicle Usage Report',
                'menu_slug' => 'menu.report.vehicle',
                'menu_icon' => 'fa-line-chart',
                'menu_url' => 'reports.vehicle',
                'menu_permission' => 'report.view',
                'menu_order' => 2,
                'menu_parent' => 13,
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

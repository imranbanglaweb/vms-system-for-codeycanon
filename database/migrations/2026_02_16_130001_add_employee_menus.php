<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get the Transport Manager role ID (or Employee role)
        $role = DB::table('roles')->where('name', 'employee')->first();
        
        if (!$role) {
            // Try to find employee-related role
            $role = DB::table('roles')->where('name', 'like', '%employee%')->first();
        }
        
        if (!$role) {
            // Use the first non-admin role
            $role = DB::table('roles')->where('name', '!=', 'admin')->first();
        }
        
        if ($role) {
            $roleId = $role->id;
            
            // Get existing parent menu IDs
            $vehicleMaintenance = DB::table('menus')->where('menu_slug', 'menu.maintenance')->first();
            $reports = DB::table('menus')->where('menu_slug', 'menu.reports')->first();
            $driverManage = DB::table('menus')->where('menu_slug', 'driver-manage')->first();
            $vehicleManage = DB::table('menus')->where('menu_slug', 'vehicle-managemant')->first();
            
            // Add Maintenance Requisition menu under Vehicle Maintenance
            if ($vehicleMaintenance) {
                $maintenanceReqId = DB::table('menus')->insertGetId([
                    'menu_name' => 'Maintenance Requisition',
                    'menu_slug' => 'maintenance-requisition',
                    'menu_icon' => 'fa-clipboard-list',
                    'parent_id' => $vehicleMaintenance->id,
                    'menu_order' => 5,
                    'menu_url' => 'maintenance.index',
                    'created_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Add permission for the menu
                DB::table('permissions')->insertOrIgnore([
                    'name' => 'maintenance-requisition-list',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // Add Maintenance Requisition Report under Reports
            if ($reports) {
                DB::table('menus')->insertOrIgnore([
                    'menu_name' => 'Maintenance Requisition Report',
                    'menu_slug' => 'maintenance-requisition-report',
                    'menu_icon' => 'fa-file-alt',
                    'parent_id' => $reports->id,
                    'menu_order' => 10,
                    'menu_url' => 'reports.maintenance',
                    'created_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Add permission
                DB::table('permissions')->insertOrIgnore([
                    'name' => 'maintenance-requisition-report-view',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // Add Vehicle Requisition Report under Reports
            if ($reports) {
                DB::table('menus')->insertOrIgnore([
                    'menu_name' => 'Vehicle Requisition Report',
                    'menu_slug' => 'vehicle-requisition-report',
                    'menu_icon' => 'fa-car',
                    'parent_id' => $reports->id,
                    'menu_order' => 11,
                    'menu_url' => 'reports.vehicle-requisition',
                    'created_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Add permission
                DB::table('permissions')->insertOrIgnore([
                    'name' => 'vehicle-requisition-report-view',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            echo "Added employee menus successfully!\n";
        } else {
            echo "No employee role found. Please run MenuSeeder first.\n";
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove the menus
        DB::table('menus')->where('menu_slug', 'maintenance-requisition')->delete();
        DB::table('menus')->where('menu_slug', 'maintenance-requisition-report')->delete();
        DB::table('menus')->where('menu_slug', 'vehicle-requisition-report')->delete();
        
        // Remove permissions
        DB::table('permissions')->where('name', 'maintenance-requisition-list')->delete();
        DB::table('permissions')->where('name', 'maintenance-requisition-report-view')->delete();
        DB::table('permissions')->where('name', 'vehicle-requisition-report-view')->delete();
    }
};

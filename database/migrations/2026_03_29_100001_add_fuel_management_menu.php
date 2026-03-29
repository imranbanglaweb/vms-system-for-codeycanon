<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if admin user exists
        $adminId = DB::table('users')->first()->id ?? 1;

        // Create Fuel Management parent menu
        $fuelManagementId = DB::table('menus')->insertGetId([
            'menu_name' => 'Fuel Management',
            'menu_slug' => 'fuel-management',
            'menu_icon' => 'fa-gas-pump',
            'menu_url' => null,
            'menu_permission' => 'fuel-manage',
            'menu_order' => 20,
            'menu_parent' => 0,
            'parent_id' => null,
            'status' => 1,
            'created_by' => $adminId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add permission for Fuel Management
        DB::table('permissions')->insertOrIgnore([
            'name' => 'fuel-manage',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Child menus under Fuel Management
        $fuelMenus = [
            [
                'menu_name' => 'Fuel Log Entry',
                'menu_slug' => 'fuel-log-entry',
                'menu_icon' => 'fa-fuel-pump',
                'menu_url' => 'fuel.log',
                'menu_permission' => 'fuel-log-entry',
                'menu_order' => 1,
                'parent_id' => $fuelManagementId,
            ],
            [
                'menu_name' => 'Fuel History',
                'menu_slug' => 'fuel-history',
                'menu_icon' => 'fa-history',
                'menu_url' => 'fuel.history',
                'menu_permission' => 'fuel-history-view',
                'menu_order' => 2,
                'parent_id' => $fuelManagementId,
            ],
        ];

        foreach ($fuelMenus as $menu) {
            DB::table('menus')->insert(array_merge($menu, [
                'menu_parent' => $fuelManagementId,
                'status' => 1,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            // Add permission
            DB::table('permissions')->insertOrIgnore([
                'name' => $menu['menu_permission'],
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Update existing driver fuel log menu to remove from driver management
        DB::table('menus')
            ->where('menu_slug', 'driver-fuel-log')
            ->update([
                'menu_permission' => 'driver-fuel-log',
                'menu_order' => 10,
            ]);

        // Add fuel log permission if not exists
        DB::table('permissions')->insertOrIgnore([
            'name' => 'driver-fuel-log',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "Fuel Management menu created successfully!\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove Fuel Management menus
        DB::table('menus')->where('menu_slug', 'fuel-management')->delete();
        DB::table('menus')->where('menu_slug', 'fuel-log-entry')->delete();
        DB::table('menus')->where('menu_slug', 'fuel-reports')->delete();
        DB::table('menus')->where('menu_slug', 'fuel-history')->delete();

        // Remove permissions
        DB::table('permissions')->whereIn('name', [
            'fuel-manage',
            'fuel-log-entry',
            'fuel-report-view',
            'fuel-history-view',
        ])->delete();

        echo "Fuel Management menu removed successfully!\n";
    }
};
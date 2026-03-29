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
        $adminId = DB::table('users')->first()->id ?? 1;
        
        // Find Fuel Management parent menu
        $fuelParent = DB::table('menus')->where('menu_slug', 'fuel-management')->first();
        
        if (!$fuelParent) {
            // Create parent menu if it doesn't exist
            $fuelParentId = DB::table('menus')->insertGetId([
                'menu_name' => 'Fuel Management',
                'menu_slug' => 'fuel-management',
                'menu_icon' => 'fa-gas-pump',
                'menu_url' => null,
                'menu_permission' => 'fuel-manage',
                'menu_order' => 17,
                'menu_parent' => 0,
                'parent_id' => null,
                'status' => 1,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $fuelParentId = $fuelParent->id;
        }

        // Add more complete fuel management menus
        $fuelFeatures = [
            [
                'menu_name' => 'Fuel Purchase Log',
                'menu_slug' => 'fuel-purchase-log',
                'menu_icon' => 'fa-shopping-cart',
                'menu_url' => 'fuel.purchase.log',
                'menu_permission' => 'fuel-purchase-manage',
                'parent_id' => $fuelParentId,
            ],
            [
                'menu_name' => 'Monthly Fuel Summary',
                'menu_slug' => 'fuel-monthly-summary',
                'menu_icon' => 'fa-calendar-alt',
                'menu_url' => 'fuel.monthly.summary',
                'menu_permission' => 'fuel-summary-view',
                'parent_id' => $fuelParentId,
            ],
            [
                'menu_name' => 'Vehicle Fuel Efficiency',
                'menu_slug' => 'fuel-efficiency',
                'menu_icon' => 'fa-tachometer-alt',
                'menu_url' => 'fuel.efficiency',
                'menu_permission' => 'fuel-efficiency-view',
                'parent_id' => $fuelParentId,
            ],
        ];

        $order = 1;
        foreach ($fuelFeatures as $menu) {
            // Check if already exists
            $exists = DB::table('menus')->where('menu_slug', $menu['menu_slug'])->exists();
            if (!$exists) {
                DB::table('menus')->insert(array_merge($menu, [
                    'menu_order' => $order++,
                    'menu_parent' => $fuelParentId,
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
        }

        // Add permissions to admin role
        $adminRole = DB::table('roles')->where('name', 'Admin')->first();
        if ($adminRole) {
            $permissions = ['fuel-purchase-manage', 'fuel-summary-view', 'fuel-efficiency-view'];
            foreach ($permissions as $perm) {
                DB::table('model_has_permissions')->insertOrIgnore([
                    'permission_id' => DB::table('permissions')->where('name', $perm)->first()->id ?? 0,
                    'model_type' => 'App\Models\User',
                    'model_id' => $adminRole->id,
                ]);
            }
        }

        echo "Fuel Management features added successfully!\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $menus = ['fuel-purchase-log', 'fuel-monthly-summary', 'fuel-efficiency'];
        DB::table('menus')->whereIn('menu_slug', $menus)->delete();
        DB::table('permissions')->whereIn('name', ['fuel-purchase-manage', 'fuel-summary-view', 'fuel-efficiency-view'])->delete();
    }
};
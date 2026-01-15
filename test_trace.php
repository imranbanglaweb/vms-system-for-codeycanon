<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();

echo "===== TRACING MENUSERVICE LOGIC =====\n\n";

// Step 1: Check user
echo "Step 1: User check\n";
echo "  User ID: " . $user->id . "\n";
echo "  User: " . $user->name . "\n";

// Step 2: Check is Super Admin
echo "\nStep 2: Check is Super Admin\n";
$isSuperAdmin = $user->hasRole('Super Admin');
echo "  isSuperAdmin: " . ($isSuperAdmin ? 'true' : 'false') . "\n";

// Step 3: Build cache key
echo "\nStep 3: Build cache key\n";
$roleNames = $user->roles->pluck('name')->implode('_');
$cacheKey  = 'sidebar_menus_' . $user->id . '_' . $roleNames;
echo "  cacheKey: " . $cacheKey . "\n";
echo "  Cache exists: " . (Cache::has($cacheKey) ? 'YES' : 'NO') . "\n";

// Step 4: Load root menus
echo "\nStep 4: Load root menus\n";
$menus = \App\Models\Menu::where('menu_parent', 0)
    ->orderBy('menu_order')
    ->get();
echo "  Root menus count: " . $menus->count() . "\n";

// Step 5: Map and filter
echo "\nStep 5: Map and filter menus\n";
$filtered = $menus->map(function ($menu) use ($user, $isSuperAdmin) {
    echo "\n  Processing menu: {$menu->menu_name} (ID: {$menu->id})\n";
    
    // Load children
    $children = \App\Models\Menu::where('menu_parent', $menu->id)
        ->orderBy('menu_order')
        ->get()
        ->filter(function ($child) use ($user, $isSuperAdmin) {
            if ($isSuperAdmin) {
                return true;
            }
            return !$child->menu_permission || $user->can($child->menu_permission);
        })
        ->values();
    
    echo "    Children count: " . $children->count() . "\n";
    
    // Check parent permission
    if ($isSuperAdmin) {
        $menu->visible = true;
        echo "    Visible: true (Super Admin)\n";
    } else {
        $hasPermission = !$menu->menu_permission || $user->can($menu->menu_permission);
        $menu->visible = $children->isNotEmpty() || $hasPermission;
        echo "    Has permission: " . ($hasPermission ? 'true' : 'false') . "\n";
        echo "    Visible: " . ($menu->visible ? 'true' : 'false') . "\n";
    }
    
    $menu->children = $children;
    return $menu;
})
->filter(fn ($menu) => $menu->visible)
->values();

echo "\n\nStep 6: Final result\n";
echo "  Filtered menus count: " . $filtered->count() . "\n";
foreach ($filtered as $menu) {
    echo "  - {$menu->menu_name}\n";
}

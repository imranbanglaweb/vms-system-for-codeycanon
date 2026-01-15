<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();
echo "User: " . $user->name . " | Super Admin: " . ($user->hasRole('Super Admin') ? 'YES' : 'NO') . "\n\n";

// Get all root menus
$rootMenus = \App\Models\Menu::where('menu_parent', 0)->orderBy('menu_order')->get();
echo "Total Root Menus: " . $rootMenus->count() . "\n";
foreach ($rootMenus as $menu) {
    echo "ID: {$menu->id}, Name: {$menu->menu_name}, Permission: {$menu->menu_permission}\n";
}

// Manually test the logic
echo "\n=== MANUAL TEST ===\n";
$isSuperAdmin = $user->hasRole('Super Admin');
echo "Is Super Admin: " . ($isSuperAdmin ? 'YES' : 'NO') . "\n";

$result = [];
foreach ($rootMenus as $menu) {
    // Load children
    $children = \App\Models\Menu::where('menu_parent', $menu->id)
        ->orderBy('menu_order')
        ->get();
    
    echo "\nMenu: {$menu->menu_name}\n";
    echo "  Children count: " . $children->count() . "\n";
    echo "  Is Super Admin: " . ($isSuperAdmin ? 'YES' : 'NO') . "\n";
    
    if ($isSuperAdmin) {
        echo "  Visible: YES (Super Admin)\n";
        $result[] = $menu;
    } else {
        $hasPermission = !$menu->menu_permission || $user->can($menu->menu_permission);
        $visible = $children->isNotEmpty() || $hasPermission;
        echo "  Has Permission: " . ($hasPermission ? 'YES' : 'NO') . "\n";
        echo "  Visible: " . ($visible ? 'YES' : 'NO') . "\n";
        if ($visible) {
            $result[] = $menu;
        }
    }
}

echo "\n=== FINAL RESULT ===\n";
echo "Count: " . count($result) . "\n";

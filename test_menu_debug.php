<?php
// Test menu display
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();

echo "=== USER INFO ===\n";
echo "User: " . $user->name . "\n";
echo "User ID: " . $user->id . "\n";
echo "Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
echo "Permissions: " . $user->permissions->pluck('name')->implode(', ') . "\n\n";

echo "=== ALL MENUS IN DB ===\n";
$allMenus = \App\Models\Menu::all();
foreach ($allMenus as $menu) {
    echo "ID: {$menu->id}, Name: {$menu->menu_name}, Parent: {$menu->menu_parent}, Permission: {$menu->menu_permission}\n";
}

echo "\n=== USER PERMISSIONS CHECK ===\n";
foreach ($allMenus as $menu) {
    $canAccess = !$menu->menu_permission || $user->can($menu->menu_permission);
    echo "Menu: {$menu->menu_name} | Permission: {$menu->menu_permission} | Can Access: " . ($canAccess ? 'YES' : 'NO') . "\n";
}

echo "\n=== SIDEBAR MENUS FROM SERVICE ===\n";
$sidebarMenus = \App\Services\MenuService::sidebar();
echo "Count: " . $sidebarMenus->count() . "\n";
foreach ($sidebarMenus as $menu) {
    echo "ID: {$menu->id}, Name: {$menu->menu_name}, Children: " . count($menu->children ?? []) . "\n";
    if ($menu->children) {
        foreach ($menu->children as $child) {
            echo "  - {$child->menu_name}\n";
        }
    }
}

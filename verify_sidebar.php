<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

echo "=== Testing sidebar menu fetch ===" . PHP_EOL;

// Simulate authenticated user
$user = \App\Models\User::find(1);
Auth::login($user);

echo "User: " . $user->name . PHP_EOL;
echo "Is Super Admin: " . ($user->hasRole('Super Admin') ? 'Yes' : 'No') . PHP_EOL;
echo "Has role-manage: " . ($user->hasPermissionTo('role-manage') ? 'Yes' : 'No') . PHP_EOL;

echo PHP_EOL . "=== Fetching sidebar menus ===" . PHP_EOL;

// Fetch menus using the same logic as MenuService::sidebar()
$menus = Menu::where('menu_parent', 0)
    ->orderBy('menu_order', 'ASC')
    ->get();

echo "Total parent menus: " . $menus->count() . PHP_EOL;

$filtered = $menus->map(function ($menu) use ($user) {
    $isSuperAdmin = $user->hasRole('Super Admin');

    $children = Menu::where('menu_parent', $menu->id)
        ->orderBy('menu_order')
        ->get()
        ->filter(function ($child) use ($user, $isSuperAdmin) {
            if ($isSuperAdmin) {
                return true;
            }
            return !$child->menu_permission || $user->can($child->menu_permission);
        })
        ->values();

    if ($isSuperAdmin) {
        $menu->visible = true;
    } else {
        $hasPermission = !$menu->menu_permission || $user->can($menu->menu_permission);
        $menu->visible = $children->isNotEmpty() || $hasPermission;
    }

    $menu->children = $children;

    return $menu;
})
->filter(fn ($menu) => $menu->visible)
->values();

echo "Visible parent menus: " . $filtered->count() . PHP_EOL;

foreach($filtered as $menu) {
    echo PHP_EOL . $menu->menu_order . '. ' . $menu->menu_name . ' (perm: ' . $menu->menu_permission . ')' . PHP_EOL;
    foreach($menu->children as $child) {
        echo '   - ' . $child->menu_order . '. ' . $child->menu_name . PHP_EOL;
    }
}

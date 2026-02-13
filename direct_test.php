<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\User;

echo "=== Direct Menu Test ===" . PHP_EOL;

$user = User::find(1);
Auth::login($user);

echo "Authenticated as: " . $user->name . PHP_EOL;
echo "Roles: " . implode(', ', $user->getRoleNames()->toArray()) . PHP_EOL;
echo "Has role-manage: " . ($user->hasPermissionTo('role-manage') ? 'Yes' : 'No') . PHP_EOL;
echo "Has role 'Super Admin': " . ($user->hasRole('Super Admin') ? 'Yes' : 'No') . PHP_EOL;

echo PHP_EOL . "=== MenuService::sidebar() ===" . PHP_EOL;
$menus = \App\Services\MenuService::sidebar();
echo "Visible menus: " . $menus->count() . PHP_EOL;

foreach($menus as $menu) {
    echo $menu->menu_order . '. ' . $menu->menu_name . PHP_EOL;
}

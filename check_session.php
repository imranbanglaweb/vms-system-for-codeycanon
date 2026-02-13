<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

echo "=== Session Check ===" . PHP_EOL;

$user = Auth::user();
if ($user) {
    echo "Current user: " . $user->name . PHP_EOL;
    echo "User ID: " . $user->id . PHP_EOL;
    echo "Roles: " . implode(', ', $user->getRoleNames()->toArray()) . PHP_EOL;
    echo "Is Super Admin: " . ($user->hasRole('Super Admin') ? 'Yes' : 'No') . PHP_EOL;
} else {
    echo "Not authenticated" . PHP_EOL;
}

echo PHP_EOL . "=== Session ID ===" . PHP_EOL;
echo Session::getId() . PHP_EOL;

echo PHP_EOL . "=== Menus via Service ===" . PHP_EOL;
$menus = \App\Services\MenuService::sidebar();
foreach($menus as $m) {
    echo $m->menu_order . '. ' . $m->menu_name . PHP_EOL;
}

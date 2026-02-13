<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

echo "=== Final Menu Structure ===" . PHP_EOL;

$menus = DB::table('menus')->where('menu_parent', 0)->orderBy('menu_order')->get();
foreach($menus as $menu) {
    echo $menu->menu_order . '. ' . $menu->menu_name . ' (URL: ' . $menu->menu_url . ')' . PHP_EOL;
}

echo PHP_EOL . "=== Route Verification ===" . PHP_EOL;
$routes = [
    'home',
    'settings.index',
    'adminroles.index',
    'admin.plans.index'
];
foreach($routes as $route) {
    echo $route . ': ' . (Route::has($route) ? 'OK' : 'MISSING') . PHP_EOL;
}

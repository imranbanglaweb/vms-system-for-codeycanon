<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

echo "=== Route Check ===" . PHP_EOL;
echo 'Route adminroles.index exists: ' . (Route::has('adminroles.index') ? 'Yes' : 'No') . PHP_EOL;
echo 'Route admin.roles.index exists: ' . (Route::has('admin.roles.index') ? 'Yes' : 'No') . PHP_EOL;

$menu = DB::table('menus')->where('menu_name', 'Roles & Permissions')->first();
echo 'Roles & Permissions URL: ' . $menu->menu_url . PHP_EOL;

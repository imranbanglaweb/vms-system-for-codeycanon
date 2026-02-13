<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

echo "=== Checking role-manage permission ===" . PHP_EOL;
$perm = Permission::where('name', 'role-manage')->first();
if ($perm) {
    echo 'Permission exists: ' . $perm->name . PHP_EOL;
} else {
    echo 'Permission NOT FOUND - creating it...' . PHP_EOL;
    Permission::create(['name' => 'role-manage', 'guard_name' => 'web']);
    echo 'Created role-manage permission' . PHP_EOL;
}

echo PHP_EOL . "=== All permissions ===" . PHP_EOL;
$perms = Permission::pluck('name');
foreach($perms as $p) {
    echo '- ' . $p . PHP_EOL;
}

echo PHP_EOL . "=== Checking menus with role-manage permission ===" . PHP_EOL;
$menus = DB::table('menus')->where('menu_permission', 'role-manage')->get();
foreach($menus as $m) {
    echo 'Menu: ' . $m->menu_name . ' (Order: ' . $m->menu_order . ')' . PHP_EOL;
}

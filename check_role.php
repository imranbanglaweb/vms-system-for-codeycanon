<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

echo "=== Checking super-admin role ===" . PHP_EOL;
$role = Role::where('name', 'super-admin')->first();
if ($role) {
    echo 'Role found: ' . $role->name . PHP_EOL;
    $perms = $role->permissions->pluck('name');
    echo 'Permissions count: ' . $perms->count() . PHP_EOL;
    echo 'Has role-manage: ' . ($perms->contains('role-manage') ? 'Yes' : 'No') . PHP_EOL;
} else {
    echo 'super-admin role NOT FOUND' . PHP_EOL;
    $roles = Role::pluck('name');
    echo 'Available roles: ' . implode(', ', $roles->toArray()) . PHP_EOL;
}

echo PHP_EOL . "=== Checking all roles ===" . PHP_EOL;
$roles = Role::with('permissions')->get();
foreach($roles as $r) {
    echo 'Role: ' . $r->name . ' - ' . $r->permissions->count() . ' permissions' . PHP_EOL;
}

echo PHP_EOL . "=== Menu rendering check ===" . PHP_EOL;
$menus = DB::table('menus')->where('menu_parent', 0)->orderBy('menu_order')->get();
foreach($menus as $m) {
    echo $m->menu_order . '. ' . $m->menu_name . ' (Permission: ' . $m->menu_permission . ')' . PHP_EOL;
}

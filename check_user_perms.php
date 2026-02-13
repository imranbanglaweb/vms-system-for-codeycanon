<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;

echo "=== Checking user permissions ===" . PHP_EOL;

// Get first user (likely admin)
$user = User::first();
if ($user) {
    echo "User: " . $user->name . " (ID: " . $user->id . ")" . PHP_EOL;

    // Get roles
    $roles = $user->getRoleNames();
    echo "Roles: " . implode(', ', $roles->toArray()) . PHP_EOL;

    // Get permissions
    $perms = $user->getAllPermissions()->pluck('name');
    echo "Total permissions: " . $perms->count() . PHP_EOL;

    echo PHP_EOL . "Has role-manage permission: " . ($user->hasPermissionTo('role-manage') ? 'YES' : 'NO') . PHP_EOL;
} else {
    echo "No users found" . PHP_EOL;
}

echo PHP_EOL . "=== Checking super-admin role ===" . PHP_EOL;
$role = Role::where('name', 'super-admin')->first();
if ($role) {
    echo "Role: " . $role->name . PHP_EOL;
    $rolePerms = $role->permissions->pluck('name');
    echo "Permissions count: " . $rolePerms->count() . PHP_EOL;
    echo "Has role-manage: " . ($rolePerms->contains('role-manage') ? 'YES' : 'NO') . PHP_EOL;
} else {
    echo "super-admin role not found" . PHP_EOL;
}

echo PHP_EOL . "=== All roles ===" . PHP_EOL;
$roles = Role::with('permissions')->get();
foreach($roles as $r) {
    echo $r->name . ": " . $r->permissions->count() . " permissions" . PHP_EOL;
}

<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();

echo "User: " . $user->name . "\n";
echo "User ID: " . $user->id . "\n";
echo "Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";

// Direct hasRole check
$result = $user->hasRole('Super Admin');
echo "\n\$user->hasRole('Super Admin'): " . var_export($result, true) . "\n";

// Check all roles
echo "\nAll roles in database:\n";
\Spatie\Permission\Models\Role::all()->each(function ($role) {
    echo "  - " . $role->name . "\n";
});

// Check if Super Admin role exists
$superAdminRole = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->first();
echo "\nSuper Admin role exists: " . ($superAdminRole ? 'YES' : 'NO') . "\n";
if ($superAdminRole) {
    echo "Super Admin permissions count: " . $superAdminRole->permissions->count() . "\n";
}

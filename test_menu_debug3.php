<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();

echo "Testing MenuService::sidebar()\n";
$result = \App\Services\MenuService::sidebar();
echo "Result count: " . $result->count() . "\n";
echo "Result type: " . gettype($result) . "\n";
var_dump($result);

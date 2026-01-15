<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Auth::user(): " . var_export(\Illuminate\Support\Facades\Auth::user(), true) . "\n";

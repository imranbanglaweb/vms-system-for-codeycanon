<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST 1: Direct call ===\n";
$result1 = \App\Services\MenuService::sidebar();
echo "Result 1 count: " . $result1->count() . "\n";
foreach ($result1 as $menu) {
    echo "  - {$menu->menu_name}\n";
}

echo "\n=== TEST 2: Clear cache and call again ===\n";
Cache::flush();
$result2 = \App\Services\MenuService::sidebar();
echo "Result 2 count: " . $result2->count() . "\n";
foreach ($result2 as $menu) {
    echo "  - {$menu->menu_name}\n";
}

echo "\n=== TEST 3: Call again (should use cache) ===\n";
$result3 = \App\Services\MenuService::sidebar();
echo "Result 3 count: " . $result3->count() . "\n";
foreach ($result3 as $menu) {
    echo "  - {$menu->menu_name}\n";
}

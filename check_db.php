<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Database Connection ===" . PHP_EOL;
try {
    $connected = DB::connection()->getPdo();
    echo "Connected to: " . DB::connection()->getDatabaseName() . PHP_EOL;
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Tables in database ===" . PHP_EOL;
try {
    $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
    foreach($tables as $table) {
        echo $table . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error listing tables: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Menus table ===" . PHP_EOL;
try {
    $count = DB::table('menus')->count();
    echo "Menus count: " . $count . PHP_EOL;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Parent Menus ===" . PHP_EOL;
try {
    $menus = DB::table('menus')->where('menu_parent', 0)->orderBy('menu_order')->get();
    foreach($menus as $m) {
        echo $m->menu_order . '. ' . $m->menu_name . ' (perm: ' . $m->menu_permission . ')' . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\TranslationService;

$service = app(TranslationService::class);
echo 'Service test: ' . $service->get('Hello', 'frontend', [], 'en') . PHP_EOL;

// Test with a key that should exist
$firstTranslation = DB::table('translations')->first();
if ($firstTranslation) {
    echo 'Testing existing key: ' . $service->get($firstTranslation->key, $firstTranslation->group, [], 'en') . PHP_EOL;
}
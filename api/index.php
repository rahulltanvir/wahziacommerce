<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

echo '<pre>';

try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "1. AUTOLOAD OK\n";

    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "2. APP BOOTSTRAP OK\n";

    echo "3. VIEW BOUND: ";
    echo $app->bound('view') ? "YES\n" : "NO\n";

    echo "4. LOADED PROVIDERS:\n";
    foreach (array_keys($app->getLoadedProviders()) as $provider) {
        if (str_contains($provider, 'View')) {
            echo $provider . "\n";
        }
    }

    echo "5. REQUEST START\n";

    $app->useStoragePath('/tmp/storage');

    $request = \Illuminate\Http\Request::capture();

    echo "6. REQUEST CAPTURED\n";

    $app->handleRequest($request);

} catch (\Throwable $e) {

    http_response_code(500);

    echo "\n--- ORIGINAL ERROR ---\n";
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
    echo "\n" . $e->getTraceAsString();
}

echo '</pre>';

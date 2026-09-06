<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

echo '<pre>';

try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "1. AUTOLOAD OK\n";

    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "2. APP BOOTSTRAP OK\n";

    $app->useStoragePath('/tmp/storage');

    echo "3. APP PROVIDERS:\n";
    print_r($app->make('config')->get('app.providers'));

    echo "\n4. CACHED SERVICES PATH:\n";
    echo $app->getCachedServicesPath() . "\n";

    echo "\n5. SERVICES CACHE EXISTS: ";
    echo file_exists($app->getCachedServicesPath()) ? "YES\n" : "NO\n";

    echo "\n6. PACKAGE MANIFEST:\n";
    $manifest = $app->make(\Illuminate\Foundation\PackageManifest::class);
    print_r($manifest->providers());

    echo "\n7. REGISTERED PROVIDERS BEFORE REQUEST:\n";
    print_r(array_keys($app->getLoadedProviders()));

    echo "\n8. REQUEST START\n";

    $request = \Illuminate\Http\Request::capture();

    $app->handleRequest($request);

    echo "\n\n9. REQUEST FINISHED\n";

    echo "\n10. VIEW BOUND AFTER REQUEST: ";
    echo $app->bound('view') ? "YES\n" : "NO\n";

    echo "\n11. REGISTERED PROVIDERS AFTER REQUEST:\n";
    print_r(array_keys($app->getLoadedProviders()));

} catch (\Throwable $e) {

    http_response_code(500);

    echo "\n--- ERROR ---\n";
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
    echo "\n" . $e->getTraceAsString();
}

echo '</pre>';
?>
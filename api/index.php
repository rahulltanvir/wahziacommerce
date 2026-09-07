<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $app->useStoragePath('/tmp/storage');

    foreach ([
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/framework/views',
        '/tmp/storage/logs',
    ] as $directory) {
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    $request = \Illuminate\Http\Request::capture();

    $app->handleRequest($request);

} catch (\Throwable $e) {
    http_response_code(500);

    echo '<pre>';
    echo 'ERROR: ' . get_class($e) . "\n";
    echo 'MESSAGE: ' . $e->getMessage() . "\n";
    echo 'FILE: ' . $e->getFile() . "\n";
    echo 'LINE: ' . $e->getLine() . "\n";
    echo $e->getTraceAsString();
    echo '</pre>';
}
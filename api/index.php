<?php

use Illuminate\Http\Request;

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', '/tmp/php-error.log');

try {
    require __DIR__ . '/../vendor/autoload.php';

    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $app->useStoragePath('/tmp/storage');

    $directories = [
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/framework/views',
        '/tmp/storage/logs',
    ];

    foreach ($directories as $directory) {
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    $app->handleRequest(Request::capture());

} catch (\Throwable $e) {
    http_response_code(500);

    echo '<pre>';
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    echo 'FILE: ' . $e->getFile() . PHP_EOL;
    echo 'LINE: ' . $e->getLine() . PHP_EOL;
    echo PHP_EOL;
    echo $e->getTraceAsString();
    echo '</pre>';
}
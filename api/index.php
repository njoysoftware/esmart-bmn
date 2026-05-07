<?php

define('LARAVEL_START', microtime(true));
// Clear cached config
@unlink('/tmp/config.php');
@unlink('/tmp/routes.php');
@unlink('/tmp/events.php');
@unlink('/tmp/packages.php');
@unlink('/tmp/services.php');

if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Illuminate\Http\Request::capture());

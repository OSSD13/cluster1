<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../html/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../html/vendor/autoload.php';

$app = require_once __DIR__.'/../html/bootstrap/app.php';

$app->handleRequest(
    Request::capture()
)->send();

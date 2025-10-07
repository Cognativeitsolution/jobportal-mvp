<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Load Composer autoload
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Handle the request
$app->handleRequest(Request::capture());

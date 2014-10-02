<?php

/**
 * Register the Auto Loader
 */
require __DIR__.'/../bootstrap/autoload.php';

/**
 * Start the app
 */
$app = require_once __DIR__.'/../bootstrap/start.php';

/**
 * Run the app
 */
$app->run();
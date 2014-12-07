<?php

use Symfony\Component\HttpFoundation\Request;

/**
 * Start the app
 */
$app = require_once __DIR__.'/../bootstrap/start.php';

/**
 * Run the app
 */
if ('prod' === $app['env']) {
    Request::setTrustedProxies(['127.0.0.1', '::1']);
    $app['http_cache']->run();
} else {
    $app->run();
}
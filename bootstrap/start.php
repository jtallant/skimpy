<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Skimpy\Application;

$app['path.base'] = realpath(__DIR__.'/../');

/**
 * Register the Skimpy Provider
 */
$app->register(new Skimpy\Provider\SkimpyProvider);

date_default_timezone_set($app['site.timezone']);

require __DIR__.'/../config/routes.php';

return $app;
<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Skimpy\Application;

$app['path.base'] = realpath(__DIR__.'/../');

/**
 * Load the environment variables if there are any
 */
if (file_exists($app['path.base'].'/.env')) {
    Dotenv::load($app['path.base']);
}

$app['env'] = getenv('APP_ENV') ?: 'prod';

/**
 * Register the configs before registering the providers
 * so they can be used when configuring some of the providers.
 */
require __DIR__.'/config_loader.php';

# TODO: Validate config here.

require __DIR__.'/providers.php';

/**
 * Register the configs again in case any of the providers override them.
 */
require __DIR__.'/config_loader.php';

date_default_timezone_set($app['site.timezone']);

require __DIR__.'/../app/routes.php';

return $app;
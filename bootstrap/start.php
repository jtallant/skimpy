<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application;

$app['path.base'] = __DIR__.'/../';

/**
 * Register Default Configs
 */
$app->register(
    new Igorw\Silex\ConfigServiceProvider(
        __DIR__."/../config/default.yml",
        ['path.base' => $app['path.base']]
    )
);

/**
 * Load the environment variables if there are any
 */
if (file_exists($app['path.base'].'/.env')) {
    Dotenv::load($app['path.base']);
}

$app['env'] = getenv('APP_ENV') ?: 'prod';

/**
 * Override the Default Configs with the current environment configs
 * if there is a config file matching the environment name.
 */
if (file_exists(__DIR__."/../config/{$app['env']}.yml")) {
    $app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/../config/{$app['env']}.yml"));
}

require __DIR__.'/providers.php';

$app['content_types'] = [];

if (file_exists($app['path.base'].'/config/content/taxonomies.yml')) {
    $app['content_types'] = Symfony\Component\Yaml\Yaml::parse($app['path.base'].'/config/content/types.yml');
}

date_default_timezone_set($app['site.timezone']);

require __DIR__.'/../app/routes.php';

return $app;
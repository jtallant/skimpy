<?php

/**
 * Register Default Configs
 */
$app->register(
    new Igorw\Silex\ConfigServiceProvider(
        $app['path.base'].'/config/default.yml',
        [
            'path.base' => $app['path.base'],
            'mailer.username' => getenv('MAILER_USERNAME'),
            'mailer.password' => getenv('MAILER_PASSWORD')
        ]
    )
);

/**
 * Override the Default Configs with the current environment configs
 * if there is a config file matching the environment name.
 */
if (file_exists($app['path.base']."/config/{$app['env']}.yml")) {
    $app->register(new Igorw\Silex\ConfigServiceProvider($app['path.base']."/config/{$app['env']}.yml"));
}
<?php

error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/../config/site.php';

date_default_timezone_set($app['site.timezone']);

require __DIR__.'/../routes.php';

require __DIR__.'/../config/providers.php';

return $app;
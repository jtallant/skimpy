<?php namespace Skimpy;

use Silex\Application;
use Silex\ServiceProviderInterface;

class SkimpyServiceProvider implements ServiceProviderInterface {

    public function register(Application $app)
    {
        $app['skimpy'] = new Skimpy($app);

        if (false === isset($app['posts'])) {
            $app['posts'] = [];
        }

        if (false === isset($app['pages'])) {
            $app['pages'] = [];
        }
    }

    public function boot(Application $app) {}
}
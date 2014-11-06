<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class Finder implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['finder'] = function() {
            return new \Symfony\Component\Finder\Finder;
        };
    }

    public function boot(Application $app)
    {

    }
}
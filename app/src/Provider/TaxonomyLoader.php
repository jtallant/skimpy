<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class TaxonomyLoader implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['taxonomyLoader'] = function() {
            return new \Skimpy\TaxonomyLoader;
        };
    }

    public function boot(Application $app)
    {

    }
}
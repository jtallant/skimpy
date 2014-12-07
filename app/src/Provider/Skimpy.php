<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class Skimpy
 *
 * @package Skimpy\Provider
 */
class Skimpy implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['skimpy'] = $app->share(function($app) {
            return new \Skimpy\Service\Skimpy($app['skimpy.repository.content']);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
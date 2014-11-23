<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class Finder
 *
 * @package Skimpy\Provider
 */
class Finder implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['skimpy.finder'] = function() {
            return new \Symfony\Component\Finder\Finder;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {

    }
}
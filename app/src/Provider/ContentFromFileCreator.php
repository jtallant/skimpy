<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class ContentFromFileCreator
 *
 * @package Skimpy\Provider
 */
class ContentFromFileCreator implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['skimpy.contentFromFileCreator'] = new \Skimpy\ContentFromFileCreator;
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
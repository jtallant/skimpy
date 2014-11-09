<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ContentFromFileCreator implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $creator = new \Skimpy\ContentFromFileCreator($app['path.pages'], $app['path.posts']);
        $app['contentFromFileCreator'] = $creator;
    }

    public function boot(Application $app)
    {
    }
}
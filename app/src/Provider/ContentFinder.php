<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ContentFinder implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        # TODO: Clean up
        # Config should be validated elsewhere
        if (false === isset($app['path.content'])) {
            throw new \Exception('The path.content config is missing.');
        }

        if (false === is_readable($app['path.content'])) {
            throw new \Exception('The '.$app['path.content'].' is not readable');
        }

        $contentFinder = new \Skimpy\ContentFinder(
            $app['finder'],
            $app['contentFromFileCreator'],
            $app['path.content']
        );

        $app['contentFinder'] = $contentFinder;
    }

    public function boot(Application $app)
    {

    }
}
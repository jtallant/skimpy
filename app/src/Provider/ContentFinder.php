<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ContentFinder implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        # TODO: Clean up
        # Config should be validated elsewhere
        if (false === isset($app['path.pages'])) {
            throw new \Exception('The path.pages config is missing.');
        }

        if (false === isset($app['path.posts'])) {
            throw new \Exception('The path.posts config is missing.');
        }

        if (false === is_readable($app['path.pages'])) {
            throw new \Exception('The '.$app['path.pages'].' is not readable');
        }

        if (false === is_readable($app['path.posts'])) {
            throw new \Exception('The '.$app['path.posts'].' is not readable');
        }

        $contentFinder = new \Skimpy\ContentFinder(
            $app['finder'],
            $app['contentFromFileCreator'],
            $app['path.pages'],
            $app['path.posts']
        );

        $app['contentFinder'] = $contentFinder;
    }

    public function boot(Application $app)
    {

    }
}
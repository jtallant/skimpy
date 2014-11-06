<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ContentFileFinder implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        # TODO: Clean up
        # Config should be validated elsewhere
        if (false === isset($app['site.pages_dir'])) {
            throw new \Exception('The site.pages_dir config is missing.');
        }

        if (false === isset($app['site.posts_dir'])) {
            throw new \Exception('The site.posts_dir config is missing.');
        }

        if (false === is_readable($app['site.pages_dir'])) {
            throw new \Exception('The '.$app['site.pages_dir'].' is not readable');
        }

        if (false === is_readable($app['site.posts_dir'])) {
            throw new \Exception('The '.$app['site.posts_dir'].' is not readable');
        }

        $contentFileFinder = new \Skimpy\ContentFileFinder($app['finder'], $app['site.pages_dir'], $app['site.posts_dir']);
        $app['contentFileFinder'] = $contentFileFinder;
    }

    public function boot(Application $app)
    {

    }
}
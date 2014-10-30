<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ContentLoader implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        if (false === isset($app['site.content_dir'])) {
            throw new \Exception('The site.content_dir config is missing.');
        }

        if (false === is_readable($app['site.content_dir'])) {
            throw new \Exception('Could not read from the content directory '.$app['site.content_dir'].'.');
        }

        $app['skimpy.contentLoader'] = new \Skimpy\ContentLoader($app['site.content_dir']);
    }

    public function boot(Application $app)
    {

    }
}
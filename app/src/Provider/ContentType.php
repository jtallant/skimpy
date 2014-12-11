<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class ContentType
 *
 * @package Skimpy\Provider
 */
class ContentType implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['skimpy.repository.content_type'] = $app->share(function($app) {
            return new \Skimpy\Repository\ContentType(
                $app['content_types'],
                $app['skimpy.transformer.array_to_content_type']
            );
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
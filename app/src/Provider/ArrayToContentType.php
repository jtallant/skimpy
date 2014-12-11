<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class ArrayToContentType
 *
 * @package Skimpy\Provider
 */
class ArrayToContentType implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['skimpy.transformer.array_to_content_type'] = $app->share(function($app) {
            return new \Skimpy\Transformer\ArrayToContentType(
                $app['skimpy.transformer.array_to_term']
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
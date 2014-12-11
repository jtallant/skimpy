<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class ArrayToTerm
 *
 * @package Skimpy\Provider
 */
class ArrayToTerm implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['skimpy.transformer.array_to_term'] = $app->share(function($app) {
            return new \Skimpy\Transformer\ArrayToTerm($app['skimpy.repository.content_item']);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
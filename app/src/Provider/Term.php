<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class Term
 *
 * @package Skimpy\Provider
 */
class Term implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['skimpy.repository.term'] = $app->share(function($app) {
            return new \Skimpy\Repository\Term(
                $app['content_types'],
                $app['skimpy.transformer.array_to_content_type'],
                $app['skimpy.repository.content_item']
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
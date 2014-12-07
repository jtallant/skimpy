<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class ContentItemRepository
 *
 * @package Skimpy\Provider
 */
class ContentItemRepository implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        if (false === isset($app['path.content'])) {
            throw new \Exception('The path.content config is missing.');
        }

        if (false === is_readable($app['path.content'])) {
            throw new \Exception('The '.$app['path.content'].' directory is not readable');
        }

        $app['skimpy.repository.content'] = $app->share(function($app) {
            return new \Skimpy\Repository\ContentItemRepository(
                new \Skimpy\Service\ContentFromFileCreator,
                $app['path.content']
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
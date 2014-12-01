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
     *
     * @throws \Exception
     */
    public function register(Application $app)
    {
        if (false === isset($app['path.content'])) {
            throw new \Exception('The path.content config is missing.');
        }

        if (false === is_readable($app['path.content'])) {
            throw new \Exception('The '.$app['path.content'].' is not readable');
        }

        $app['skimpy.repository.content'] = new \Skimpy\Repository\ContentItemRepository(
            $app['skimpy.finder'],
            $app['skimpy.contentFromFileCreator'],
            $app['path.content']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {

    }
}
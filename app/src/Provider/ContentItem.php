<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class ContentItem
 *
 * @package Skimpy\Provider
 */
class ContentItem implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['skimpy.repository.content_item'] = $app->share(function($app) {
            return new \Skimpy\Repository\ContentItem(
                new \Skimpy\Transformer\SplFileInfoToContentItem,
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
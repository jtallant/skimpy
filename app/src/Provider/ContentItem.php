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
                $app['skimpy.transformer.spl_file_info_to_content_item'],
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
<?php namespace Skimpy\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class SplFileInfoToContentItem
 *
 * @package Skimpy\Provider
 */
class SplFileInfoToContentItem implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $metadataTransformer = new \Skimpy\Transformer\SplFileInfoToMetadata($app['skimpy.repository.content_type']);
        $app['skimpy.transformer.spl_file_info_to_content_item'] = $app->share(function($app) use ($metadataTransformer) {
            return new \Skimpy\Transformer\SplFileInfoToContentItem($metadataTransformer);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
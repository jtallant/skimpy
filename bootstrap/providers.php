<?php

if ($app['http_cache.enabled']) {
    /**
     * Register the HttpCacheServiceProvider
     *
     * @link http://silex.sensiolabs.org/doc/providers/http_cache.html
     */
    $app->register(new Silex\Provider\HttpCacheServiceProvider, [
        'http_cache.cache_dir' => $app['path.base'].'/cache/http',
        'http_cache.esi'       => null,
        'http_cache.options'   => [
            'debug'            => $app['debug'],
            'default_ttl'      => (int) $app['http_cache.default_ttl']
        ]
    ]);
}

/**
 * Register the TwigServiceProvider
 *
 * @link http://silex.sensiolabs.org/doc/providers/twig.html
 */
$app->register(
    new Silex\Provider\TwigServiceProvider,
    [
        'twig.path' => $app['path.base'].'/templates',
        'twig.options' => [
            'debug' => $app['debug'],
            'cache' => $app['path.base'].'/cache/templates'
        ]
    ]
);

/**
 * Register the UrlGeneratorServiceProvider
 */
$app->register(new Silex\Provider\UrlGeneratorServiceProvider);

/**
 * Register the SwiftmailerServiceProvider
 *
 * @link http://silex.sensiolabs.org/doc/providers/swiftmailer.html
 */
$app->register(new Silex\Provider\SwiftmailerServiceProvider);

/**
 * Register the ContentItemRepository
 */
$app->register(new Skimpy\Provider\ContentItemRepository);

/**
 * Register Skimpy
 */
$app->register(new Skimpy\Provider\Skimpy);
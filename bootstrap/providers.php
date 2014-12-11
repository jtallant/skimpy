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
 * Register the ContentItem Repository
 */
$app->register(new Skimpy\Provider\ContentItem);

/**
 * Register the ArrayToTerm Transformer
 */
$app->register(new Skimpy\Provider\ArrayToTerm);

/**
 * Register the ArrayToContenType Transformer
 */
$app->register(new Skimpy\Provider\ArrayToContentType);

/**
 * Register the Term Repository
 */
$app->register(new Skimpy\Provider\Term);

/**
 * Register the ContentType Repository
 */
$app->register(new Skimpy\Provider\ContentType);

/**
 * Register Skimpy
 */
$app->register(new Skimpy\Provider\Skimpy);
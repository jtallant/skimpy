<?php

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
 * Adds a 'date_default' filter to twig
 *
 * It simply formats a date using the formatting defined by site.date_format
 */
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $defaultDateFormat = new Twig_SimpleFilter('date_default_format', function($date) use($app) {
        $format = isset($app['site.date_format']) ? $app['site.date_format'] : 'Y-m-d H:i:s';
        return $date->format($format);
    });
    $twig->addFilter($defaultDateFormat);
    return $twig;
}));

/**
 * Register the UrlGeneratorServiceProvider
 */
$app->register(new Silex\Provider\UrlGeneratorServiceProvider);

/**
 * Register the Repository Provider
 */
$app->register(new Skimpy\Provider\RepositoryProvider);

/**
 * Register the Skimpy Provider
 */
$app->register(new Skimpy\Provider\SkimpyProvider);
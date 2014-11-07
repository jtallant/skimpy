<?php

/**
 * Register the HttpCacheServiceProvider
 *
 * http://silex.sensiolabs.org/doc/providers/http_cache.html
 */
$app->register(new Silex\Provider\HttpCacheServiceProvider(), [
    'http_cache.cache_dir' => __DIR__.'/../app/cache/',
]);

/**
 * Register the TwigServiceProvider
 *
 * http://silex.sensiolabs.org/doc/providers/twig.html
 */
$app->register(
    new Silex\Provider\TwigServiceProvider(),
    ['twig.path' => __DIR__.'/../views']
);

/**
 * Register the SwiftmailerServiceProvider
 *
 * http://silex.sensiolabs.org/doc/providers/swiftmailer.html
 */
$app->register(new Silex\Provider\SwiftmailerServiceProvider());

/**
 * Register the ContentFromFileCreator
 */
$app->register(new Skimpy\Provider\ContentFromFileCreator);

/**
 * Register the Finder
 */
$app->register(new Skimpy\Provider\Finder);

/**
 * Register the ContentFileFinder
 */
$app->register(new Skimpy\Provider\ContentFileFinder);

/**
 * Register Skimpy
 */
$app->register(new Skimpy\Provider\Skimpy);
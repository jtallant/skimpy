<?php
/**
 * Routes
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use AgnosticPhp\Support\Collection;

/**
 * Home page
 */
$app->get('/', function() use ($app) {

    $data = [
        'seotitle' => $app['site.title']
    ];

    return $app->render('home.twig', $data);
})
->bind('home');

/**
 * Render contact form
 */
$app->get('/contact', function() use ($app) {

    $data = [
        'title' => 'Contact',
        'seotitle' => 'Contact'
    ];

    return $app->render('contact.twig', $data);
})
->bind('contact');

/**
 * Render category or tag archive
 *
 * Examples URIs:
 * /category/{term-slug}
 * /tag/{term-slug}
 */
$app->get('/{contentTypeSlug}/{termSlug}', function($contentTypeSlug, $termSlug) use ($app) {

    $archive = $app['skimpy']->getArchive($contentTypeSlug, $termSlug);

    if (is_null($archive)) {
        $app->abort(404);
    }

    return $app['twig']->render(
        'archive.twig',
        [
            'archiveName' => $archive->getName(),
            'seotitle'    => $archive->getName(),
            'items'       => $archive->getItems()
        ]
    );
})
->bind('archive');

/**
 * Render a page or post
 */
$app->get('/{slug}', function($slug) use ($app) {

    $contentItem = $app['skimpy']->findBySlug($slug);

    if (is_null($contentItem)) {
        $app->abort(404);
    }

    return $app['twig']->render(
        $contentItem->getTemplate().'.twig',
        [
            'contentItem' => $contentItem
        ]
    );
})
->bind('content');

/**
 * Handle 404 errors
 */
$app->error(function(HttpException $e, $code) use ($app) {

    if (404 !== $code) {
        return;
    }

    return new Response(
        $app['twig']->render(
            '404.twig',
            ['seotitle' => '404 Not Found']
        ),
        404
    );
});
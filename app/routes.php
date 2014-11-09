<?php
/**
 * Routes
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Skimpy\ContentFinder;

/**
 * Home page
 */
$app->get('/', function() use ($app) {
    return $app['twig']->render(
        'home.twig',
        [
            'seotitle' => $app['site.title']
        ]
    );
})
->bind('home');

/**
 * Render contact form
 */
$app->get('/contact', function() use ($app) {
    return $app['twig']->render(
        'contact.twig',
        [
            'title'    => 'Contact',
            'seotitle' => 'Contact'
        ]
    );
})
->bind('contact');

/**
 * Render category or tag archive
 *
 * /category/{category-name-slug}
 * /tag/{tag-name-slug}
 */
$app->get('/{archiveType}/{archiveNameSlug}', function($archiveType, $archiveNameSlug) use ($app) {

    // get the archive
    die('archive');

    $collection = $app['skimpy']->findPostsInArchive($archiveType, $archiveName);

    if (empty($collection)) {
        $app->abort(404);
    }

    return $app['twig']->render(
        'archive.twig',
        [
            'archiveName' => $archiveName,
            'seotitle'    => $archiveName,
            'collection'  => $collection
        ]
    );
})
->assert('archiveType', 'category|tag')
->bind('archive');

/**
 * Render a page or post
 */
$app->get('/{slug}', function($slug) use ($app) {

    $content = $app['skimpy']->find($slug);

    if (is_null($content)) {
        $app->abort(404);
    }

    return $app['twig']->render(
        $content->getTemplate().'.twig',
        $content->getViewData()
    );
})
->bind('content');

/**
 * Handle 404 errors
 */
$app->error(function(HttpException $e, $code) use ($app) {
    if (404 != $code) {
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
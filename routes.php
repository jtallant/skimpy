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
});

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
});

/**
 * Render category or tag archive
 *
 * /category/{category-name}
 * /tag/{tag-name}
 */
$app->get('/{archiveType}/{archiveName}', function($archiveType, $archiveName) use ($app) {

    $collection = $app['skimpy']->findPostsInArchive($archiveType, $archiveName);

    if (is_null($collection)) {
        $app->abort(404);
    }

    # Get all the posts with the matching category/tag
    # convert them to resource objects
    # put them in an array or collection
    # pass them to the view

    # collect all the posts with the archiveType
    return $app['twig']->render(
        'archive.twig',
        [
            'archiveName' => 'Web Development',
            'seotitle'   => 'Web Development',
            'collection' => $collection
        ]
    );
});

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
});

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
<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Home page
 */
$app->get('/', function() use ($app) {

    $posts = $app['skimpy']->findBy(['type' => 'post'], ['date' => 'DESC']);

    $data = [
        'seotitle' => 'Home',
        'items'    => $posts
    ];

    return $app->render('home.twig', $data);
})
->bind('home');

/**
 * Render a page or post
 */
$app->get('/{slug}', function($slug) use ($app) {

    $contentItem = $app['skimpy.content']->findOneBy(['uri' => $slug]);

    if (is_null($contentItem)) {
        $app->abort(404);
    }

    return $app->render(
        $contentItem->getTemplate().'.twig',
        ['item' => $contentItem]
    );
})
->bind('content');

/**
 * Render category/tag archive or
 * content in a subdirectory.
 *
 * Examples URIs:
 * /category/{term-slug}  (category archive)
 * /tag/{term-slug}       (tag archive)
 * /our-team/jon-doe      (page in subdirectory)
 */
$app->get('/{taxonomySlug}/{termSlug}', function($taxonomySlug, $termSlug) use ($app) {

    $uri = $taxonomySlug.'/'.$termSlug;
    $page = $app['skimpy.content']->findOneBy(['uri' => $uri]);
    if (false === is_null($page)) {
        return $app->render(
            $page->getTemplate().'.twig',
            ['item' => $page]
        );
    }

    $archive = $app['skimpy']->getArchive($taxonomySlug, $termSlug);
    if (is_null($archive)) {
        $app->abort(404);
    }

    return $app->render(
        'archive.twig',
        [
            'archiveName' => $archive['term']->getName(),
            'seotitle'    => $archive['term']->getName(),
            'items'       => $archive['items'],
        ]
    );
})
->bind('archive');

/**
 * Render content item two or more directories deep
 *
 * Examples URIs:
 * /our-team/volunteers/jane-doe (content/page/our-team/volunteers/jane-doe.md)
 * /our-team/volunteers/jon-doe  (content/page/our-team/volunteers/jon-doe.md)
 */
$app->get('/{one}/{two}/{tree}', function($one, $two, $tree) use($app) {
    $uri = $one.'/'.$two.'/'.$tree;
    $page = $app['skimpy.content']->findOneBy(['uri' => $uri]);
    if (false === is_null($page)) {
        return $app->render(
            $page->getTemplate().'.twig',
            ['item' => $page]
        );
    }

    $app->abort(404);
})
->assert('tree', '.+');

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

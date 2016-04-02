<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Home page
 */
$app->get('/', function() use ($app) {

    $entries = $app['skimpy']->findBy(['type' => 'entry'], ['date' => 'DESC']);

    $data = [
        'seotitle' => 'Home',
        'entries'  => $entries
    ];

    return $app->render('home.twig', $data);
})
->bind('home');

/**
 * Render a page or post
 */
$app->get('/{uri}', function($uri) use ($app) {

    # Single
    $entry = $app['skimpy.entries']->findOneBy(['uri' => $uri]);
    if ($entry && false === $entry->isIndex()) {
        return $app->render(
            '_defaults/entry.twig',
            ['entry' => $entry]
        );
    }

    # Index
    if ($entry && $entry->isIndex()) {
        $entries = $app['skimpy']->getIndexEntries($uri);
        return $app->render(
            '_defaults/index.twig',
            ['entry' => $entry, 'entries' => $entries]
        );
    }

    # Taxonomy (list of terms)
    $taxonomy = $app['skimpy.taxonomies']->findOneBy(['uri' => $uri]);
    if (false === is_null($taxonomy) && $taxonomy->hasPublicTermsRoute()) {
        return $app->render(
            '_defaults/taxonomy.twig',
            ['taxonomy' => $taxonomy]
        );
    }

    # Term (list of entries with term)
    $term = $app['skimpy.terms']->findOneBy(['uri' => $uri]);
    if (false === is_null($term)) {
        return $app->render(
            '_defaults/term.twig',
            ['term' => $term]
        );
    }

    $app->abort(404);
})
->assert('uri', '.+')
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

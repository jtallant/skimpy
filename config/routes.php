<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Skimpy\Http\Controller\GetController;
use Skimpy\Http\Controller\PostController;
use Skimpy\Http\Controller\PutController;
use Skimpy\Http\Controller\DeleteController;

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

$app->get('/{uri}', 'skimpy.controller.get:handle')
    ->assert('uri', '.+')
    ->bind('content')
;

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

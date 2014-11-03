<?php
/**
 * Routes
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Stringy\StaticStringy as Str;

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
 * Render category or tag archive
 *
 * /category/{category-name}
 * /tag/{tag-name}
 */
$app->get('/{archiveType}/{archiveName}', function($archiveType, $archiveName) use ($app) {
    return 'Archive code not ready yet';

    # Find out if there are any posts with a matching category or tag
    # If there are not throw 404

    # Get all the posts with the matching category/tag
    # convert them to resource objects
    # put them in an array or collection
    # pass them to the view

    # collect all the posts with the archiveType
    return $app['twig']->render(
        'archive.twig',
        [
            'seotitle'   => 'foo',
            'collection' => $collection
        ]
    );
});

/**
 * Render a page or post
 */
$app->get('/{slug}', function($slug) use ($app) {

	$resource = $app['skimpy.contentLoader']->load($slug);

	if (is_null($resource)) {
		$app->abort(404);
	}

	return $app['twig']->render(
		$resource->getTemplate().'.twig',
		$resource->getViewData()
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
			[
				'seotitle' => '404 Not Found',
				'title' => "We couldn't find the page you are looking for.",
			]
		),
		404
	);
});
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

	# All this junk will be refactored and moved into some class inside of skimpy
	# Just feeling things out for now
	$posts = $app['posts'];
	$registeredCategories = $app['categories'];
	$registeredTags = $app['tags'];

	$isTag = 'tag' === $archiveType;
	$isCategory = 'category' === $archiveType;

	$tagExists = isset($app['tags'][$archiveName]);
	$categoryExists = isset($app['categories'][$archiveName]);

	if (false === $isTag && false === $isCategory) {
		$app->abort(404);
	}

	if ($isTag && $tagExists) {
		$target = $app['tags'][$archiveName];
		$type = 'tags';
	}

	if ($isCategory && $categoryExists) {
		$target = $app['categories'][$archiveName];
		$type = 'categories';
	}

	# collect all the posts with the archiveType
	$collection = [];
	foreach ($posts as $p) {
		if (false === isset($p[$type])) {
			continue;
		}

		if (is_string($p[$type])) {
			$p[$type] = array_map('trim', explode(',',  $p[$type]));
		}

		if (in_array($target, $p[$type])) {
			$collection[] = $p;
		}
	}

	return $app['twig']->render(
		'/archives/default.twig',
		[
			'seotitle' => $target,
			'collection' => $collection
		]
	);

	$app->abort(404);
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
<?php
/**
 * Routes
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Stringy\StaticStringy as Str;

$app->get('/', function() use ($app) {
	return $app['twig']->render(
		'home.twig',
		[
			'seotitle' => $app['site.title']
		]
	);
});

# /category/{category-name}
# /tag/{tag-name}
$app->get('/{archiveType}/{archiveName}', function($archiveType, $archiveName) use ($app) {

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
		throw new NotFoundHttpException;
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

	throw new NotFoundHttpException;
});

$app->get('/{slug}', function($slug) use ($app) {

	$resource = $app['skimpy']->getResource($slug);

	if (false === $resource) {
		throw new NotFoundHttpException;
	}

    return $app['twig']->render(
    	$resource->getTemplate(),
    	[
	        'seotitle' => $resource->getSeoTitle(),
	        'title' => $resource->getTitle(),
	        'date' => $resource->getDate()
	    ]
    );
});

$app->error(function(NotFoundHttpException $e, $code) use ($app) {
	return new Response(
		$app['twig']->render(
			'404.twig',
			array(
				'seotitle' => '404 Not Found',
				'title' => "We couldn't find the page you are looking for.",
			)
		),
		404
	);
});
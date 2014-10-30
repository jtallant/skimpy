<?php
/**
 * Routes
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
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

// Load a piece of content
$app->get('/{slug}', function($slug) use ($app) {

	$content = $app['skimpy.contentLoader']->load($slug);

	if (is_null($content)) {
		$app->abort(404);
	}

	$app['skimpy.twigRenderer']->renderFromString($)

	// dd($content);

	// Twig Render 
	// @TODO: Justin - Setup your templates and use the template_from_string() in Twig to allow the content to
	// include twig syntax
	return $app['twig']->render($templateType . '.twig', [
		'metadata' => $metadata,    // array
		'content'  => $contentData  // string
	]);
});

// -------------------------------

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
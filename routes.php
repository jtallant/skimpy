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

// Load a piece of content
$app->get('/{slug}', function($slug) use ($app) {
	
	// We find the file that corresponds to this slug
	// (check pages folder then posts folder)
	
	// @TODO: Justin - Make the content directory configurable (not hard-coded)
	$contentDirectory = realpath(__DIR__ . '/content');
	
	// @TODO: Justin - Refactor this logic (to line 109) in its own service class
	if ( ! is_readable($contentDirectory)) {
		throw new \RuntimeException("Could not read from the content directory: " . $contentDirectory);
	}
	
	if (file_exists($contentDirectory . '/pages/' . $slug . '.md')) {
		$file = $contentDirectory . '/pages/' . $slug . '.md';
		$templateType = 'page';
	}
	elseif (file_exists($contentDirectory . '/posts/' . $slug . '.md')) {
		$file = $contentDirectory . '/posts/' . $slug . '.md';
		$templateType = 'post';
	}
	else {
		// If the content does not exist, we abort with a 404
		//$app->abort(404);
		throw new NotFoundHttpException;
	}
	$rawFileContents = file_get_contents($file);
	list($yamlData, $contentData) = explode('----------', $rawFileContents, 2);

	// We load the contents of that into a twig template
	// and render it 
	$metadata = Yaml::parse($yamlData);

	// Twig Render 
	// @TODO: Justin - Setup your templates and use the template_from_string() in Twig to allow the content to
	// include twig syntax
	return $app['twig']->render($templateType . '.twig', [
		'metadata' => $metadata,    // array
		'content'  => $contentData  // string
	]);
});

// -------------------------------

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
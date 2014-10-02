<?php

/**
 * Posts
 *
 * There is no real difference between a page and a post.
 * They are only separated for organizational purposes
 */
$app['posts'] = [
	'hello-world' => [
		'title' => 'Hello World',
		'date'  => 'May 16th 2014',
        'seotitle' => 'Hello World',
        'categories' => 'Example Category',
        'tags' => 'Tag1, Tag2', # can use array or string
	],
    'example-post' => [
        'title' => 'Example Post',
        'date'  => 'May 17th 2014',
        'seotitle' => 'Example Post',
        'categories' => 'Example Category',
        'tags' => ['Tag1'], # can use array or string
    ]
];

/**
 * Pages
 *
 * There is no real difference between a page and a post.
 * They are only separated for organizational purposes
 */
$app['pages'] = [
    'contact' => [
        'title' => 'Contact',
    ],
    'about-me' => [
        'title' => 'About Me',
        'date'  => 'May 16th 2014',
    ]
];

# Probably put this somewhere else or do this in a completely different way
# Need a way to map slugs to category names
$app['categories'] = [
    'example-category' => 'Example Category'
];

$app['tags'] = [
    'tag1' => 'Tag1',
    'tag2' => 'Tag2'
];
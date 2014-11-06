<?php

/*
    When the archive route is hit, Skimpy will attempt
    to take the slug value of the archive name and convert
    it to a real category or tag name.

    'web-development' becomes 'Web Development'

    It will then find all the posts that contain metadata with 'Web Development'
    as one of the categories.

    Skimpy doesn't attempt to be very smart about converting slugs
    to real category or tag names. This is because category and tag
    names should be pretty simple to begin with and it's not worth
    the complexity it would add to the code. Skimpy will simply take
    a slug and replace hyphens with spaces and then capitalize
    each word and assume that is the name of the category or tag.

    There are two common cases where you will need to register
    a custom slug to category/tag name mapping.

    1. Skimpy isn't guessing it correctly
    2. You want the slug form to be a little different than
       the actual category/tag name.

    Let's say for some reason you wanted the uri /category/foo-bar
    to render an archive for posts in the category 'Foo Bar Baz'.
    You would register the mapping like this:
    'foo-bar' => 'Foo Bar Baz'
*/

# slug-form => Actual Category or Tag Name
$app['archive_mappings'] = [
    // 'foo-bar' => 'Foo Bar Baz'
];
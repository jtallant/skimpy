<?php

$app['site.url']            = 'example.com';
$app['site.title']          = 'Site Title';
$app['site.tagline']        = 'Subtitle Here';
$app['site.author']         = 'Author Name';
$app['site.ga_tracking_id'] = 'UA-XXXXXXXX-1';
$app['site.timezone']       = 'America/Chicago';
$app['site.date_format']    = 'F dS, Y';
$app['site.meta_content']   = 'Content of meta description goes here';
$app['site.posts_dir']      = dirname(dirname(__FILE__)).'/views/posts';
$app['site.pages_dir']      = dirname(dirname(__FILE__)).'/views/pages';
$app['site.content_dir']    = dirname(dirname(__FILE__)).'/content';

# Emails.
$app['admin_email'] = 'you@example.com';
$app['site_email'] = 'you@example.com';

# SwiftMailer
# See http://silex.sensiolabs.org/doc/providers/swiftmailer.html
$app['swiftmailer.options'] = array(
    'host'       => 'host',
    'port'       => '25',
    'username'   => 'username',
    'password'   => 'password',
    'encryption' => null,
    'auth_mode'  => null
);

$app['debug'] = true;
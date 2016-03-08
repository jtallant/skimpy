# Skimpy

[![Code Climate](https://codeclimate.com/github/jtallant/skimpy/badges/gpa.svg)](https://codeclimate.com/github/jtallant/skimpy)

Skimpy is a file based blog that doesn't require any generating.

It's mainly built for developers. I built it because I want a simple file
based blog that doesn't require any generating.

## Why you might like it (or not like it)
* Creating a post is as simple as creating a new file
* It supports categories and tags
* It has no database
* It doesn't require any generating
* It's fast
* It has zero default styling
* It's built with Silex

## Status of Project
I haven't tagged a release because I'm not even considering it alpha yet.
But it does work and you can use it now if you want.
I will tag a release when the docs are complete.


## Installation & Setup
Install through composer or by downloading the zip and running composer update.

1. `composer create-project jtallant/skimpy -s dev`
1. cd into the project
1. run `php -S localhost:4000 -t web/`
1. Visit url http://localhost:4000

### Creating a blog post
1. You simply create a new file inside content/somedir/ and give it the required metadata

Some conventions you should be aware of:
* The name of the file is the slug of the blog post/page (the uri).
* The name of "somedir" in content/somedir/your-blog-post.md determines which twig template to use. In this case, templates/somedir.twig would be used as the template if it exists, else templates/default.twig would be used.
* There is no difference between a post and a page other than they use different templates.
* The name of a taxonomy file determines its slug and template. categories.yaml, uri => categories, template => categories.twig.
* If a taxonomy has no template, it will not have an archive (listing of term names). /categories (404). /categories/tag-name is still public (200 OK).
* Metadata "date" defaults to filemtime if not specified.
* Metadata "title" defaults to titleized filename if not specified.
* The metadata "date" value must be quoted.
* You can name a content file index.md to use the parent dir as the content file slug. This would be useful in a scenario such as content/our-team/index.md where index.md would be an archive of team members and the uri would be /our-team. You could have our-team/jon.md, our-team/jane.md, and our-team/index.md.
* The metadata must be valid [YAML](http://www.yaml.org/spec/1.2/spec.html).
* Every content file must include a metadata separator even if there is no metadata.
* The metadata separator must be exactly 3 hyphens.

## NOTE
* URIs according to W3C are case sensitive. This means that you will get a 404 if the casing is incorrect for some uri. You can use mod_rewrite to 301 redirect any URIs containing uppercase characters to all lowercase characters.

## BETA
* Placeholder content explains skimpy usage.
* Contact Form
* Travis CI
* Documentation

## LATER
* Built in JSON API
* Contact form (service provider)
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
Install through composer or by downloading the zip.

1. `composer create-project jtallant/skimpy -s dev`
1. cd into the project
1. run `php -S localhost:4000 -t web/`
1. Visit url http://localhost:4000

### Creating a blog post
1. You simply create a new file inside content/somedir/ and give it the required metadata

Some conventions you should be aware of:
* The name of "somedir" in content/somedir/your-blog-post.md determes which twig template to use. See templates directory.
* The name of the file is the slug of the blog post (the uri)
* title and date are required metadata for every blog post.
* The metadata must be valid [YAML](http://www.yaml.org/spec/1.2/spec.html)
* The metadata separator must be exactly 3 hyphens.

## NOTE
* URIs according to W3C are case sensitive. This means that you will get a 404
  if the casing is incorrect for some uri.
  You can use mod_rewrite to 301 redirect any URIs containing uppercase characters
  to all lowercase characters.

## BETA
* YAML Routes http://gonzalo123.com/2013/03/04/scaling-silex-applications-part-ii-using-routecollection/
* Travis CI

## LATER
* Built in JSON API
* Contact form

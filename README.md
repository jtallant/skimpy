# Skimpy

**This project is in the very early stages of development. It is not ready to use.**

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
* It comes with a swiftmailer contact form
* It's built with Silex

## Features for 1.0 will include:
* Basic routing to posts and pages
* Archives (for categories and tags)
* Twig templating
* Out of the box contact form

## Features for 1.1 will include:
* CLI for creating posts, pages

## Set up
* Clone this repo

## TODO
* Slug option in metadata
* Slug property on content class
* Collection for archives
* Twig extension for rendering date in site default date format
* Env detection
* Tests
* Import from WordPress
* A whole bunch of other stuff

## NOTE
* URL according to W3C are case sensitive. This means that you will get a 404
  if the casing is incorrect for some uri.
  You can use mod_rewrite to 301 redirect any URIs containing uppercase characters
  to all lowercase characters.
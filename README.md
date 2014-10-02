# Skimpy Slate

**This project is in the very early stages of development. It is not ready to use.**

Skimpy will provide basic blog functionality without the use of a database but it is **not** a static site generator.

Features will include:
* Basic routing to posts and pages
* Twig templating
* Post archives
* Out of the box contact form

## Set up
* Clone this repo
* Clone jtallant/skimpy into the vendor directory. Make sure the dir name is just skimpy.

jtallant/skimpy isn't loaded through composer because it's in such early development there is no point in publishing it. It is easier to develop on it without having to commit then composer update.

## TODO
* Move the archive routing code into skimpy
* Tests
* A whole bunch of other stuff

## Notes
* The composer.json file will probably look something like this after the project is ready for initial release.

```
{
	"name": "jtallant/skimpy-slate",
	"description": "simple php blog",
	"keywords": "blog",
	"license": "MIT",
    "authors": [
        {
            "name": "Justin Tallant",
            "email": "jtallant07@gmail.com"
        }
    ],
	"type": "project",
    "require": {
    	"jtallant/skimpy": "dev-master"
    }
}
```

Skimpy Slate will be a template for a blog, and skimpy will provide the actual functionality.

They will be two separate composer packages.
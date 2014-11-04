<?php namespace Skimpy\Contracts;

# Should I bother with this?
interface ContentFinder
{
    public function findByName($name);

    public function findPostsContaining($string);
}
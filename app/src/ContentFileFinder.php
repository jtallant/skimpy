<?php namespace Skimpy;

use Symfony\Component\Finder\Finder;

class ContentFileFinder
{
    /**
     * @var Symfony\Component\Finder\Finder
     */
    protected $finder;

    /**
     * @var string
     */
    protected $pagesDirectory;

    /**
     * @var string
     */
    protected $postsDirectory;

    const DEFAULT_EXTENSION = '.md';

    public function __construct(Finder $finder, $pagesDirectory, $postsDirectory)
    {
        if (false === is_readable($pagesDirectory)) {
            throw new \Exception("Could not read from the pages directory $pagesDirectory");
        }

        if (false === is_readable($postsDirectory)) {
            throw new \Exception("Could not read from the posts directory $postsDirectory");
        }

        $this->finder = $finder;
        $this->pagesDirectory = $pagesDirectory;
        $this->postsDirectory = $postsDirectory;
    }

    /**
     * Find a post or page by name
     *
     * @param string $name name of the file without extension
     *
     * @return null|string
     */
    public function findByName($name)
    {
        $files = $this->finder
            ->files()
            ->in([$this->pagesDirectory, $this->postsDirectory])
            ->name($name.'.*');

        if (empty($files->count())) {
            return null;
        }

        if ($files->count() > 1) {
            # TODO: Better exception
            # List the file paths of the duplicates
            throw new \Exception("You can't have pages and posts with the same name.");
        }

        foreach ($files as $f) {
            return $f;
        }
    }

    public function findPostsContaining($string)
    {
        return $this->finder
            ->files()
            ->in($this->postsDirectory)
            ->contains("/$string/i");
    }

    protected function pagePath($slug)
    {
        return $this->pagesDirectory.'/'.$slug.static::DEFAULT_EXTENSION;
    }

    protected function postPath($slug)
    {
        return $this->postsDirectory.'/'.$slug.static::DEFAULT_EXTENSION;
    }
}
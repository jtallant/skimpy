<?php namespace Skimpy;

use Symfony\Component\Finder\Finder;

class ContentFileFinder
{
    /**
     * @var Symfony\Component\Finder\Finder
     */
    protected $finder;

    /**
     * @var Skimpy\ContentFromFileCreator
     */
    protected $contentFromFileCreator;

    /**
     * @var string
     */
    protected $pagesDirectory;

    /**
     * @var string
     */
    protected $postsDirectory;

    public function __construct(
        Finder $finder,
        ContentFromFileCreator $contentFromFileCreator,
        $pagesDirectory,
        $postsDirectory
    ) {
        if (false === is_readable($pagesDirectory)) {
            throw new \Exception("Could not read from the pages directory $pagesDirectory");
        }

        if (false === is_readable($postsDirectory)) {
            throw new \Exception("Could not read from the posts directory $postsDirectory");
        }

        $this->finder = $finder;
        $this->contentFromFileCreator = $contentFromFileCreator;
        $this->pagesDirectory = $pagesDirectory;
        $this->postsDirectory = $postsDirectory;
    }

    /**
     * Find a post or page by name
     *
     * @param string $name name of the file without extension
     *
     * @return Skimpy\Content|null
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
            # TODO: DuplicateContentFileNameException
            # List the file paths of the duplicates
            throw new \Exception("You can't have pages and posts with the same name.");
        }

        foreach ($files as $f) {
            return $this->contentFromFileCreator->createContentObject($f);
        }
    }

    public function findPostsContainingAttributeValue($attribute, $targetValue)
    {
        $files = $this->finder
            ->files()
            ->in($this->postsDirectory);

        $getAttributeValue = $this->getGetterMethodForAttribute($attribute);
        $posts = [];
        foreach ($files as $f) {
            $content = $this->contentFromFileCreator->createContentObject($f);
            $attrValue = $content->$getAttributeValue();

            if (is_array($attrValue) && in_array($targetValue, $attrValue)) {
                $posts[] = $content;
                continue;
            }

            if ($attrValue == $targetValue) {
                $posts[] = $content;
            }
        }

        return $posts;
    }

    protected function getGetterMethodForAttribute($attribute)
    {
        $refClass = new \ReflectionClass("\Skimpy\Content");
        $methods = $refClass->getMethods();
        foreach ($methods as $m) {
            $isGetter = 'get' === substr($m->name, 0, 3);
            $getterContainsAttribute = false !== stripos($m->name, $attribute);
            if ($isGetter && $getterContainsAttribute) {
                return $m->name;
            }
        }
        throw new \Exception("\Skimpy\Content has no getter method for attribute '$attribute'.");
    }
}
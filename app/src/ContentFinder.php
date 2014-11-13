<?php namespace Skimpy;

use Symfony\Component\Finder\Finder;

class ContentFinder
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
    protected $contentPath;

    public function __construct(
        Finder $finder,
        ContentFromFileCreator $contentFromFileCreator,
        $contentPath
    ) {
        if (false === is_readable($contentPath)) {
            throw new \Exception("Could not read from the content directory $contentPath");
        }

        $this->finder = $finder;
        $this->contentFromFileCreator = $contentFromFileCreator;
        $this->contentPath = $contentPath;
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
            ->in($this->contentPath)
            ->name($name.'.*');

        if (empty($files->count())) {
            return null;
        }

        if ($files->count() > 1) {
            # TODO: DuplicateContentFileNameException
            # List the file paths of the duplicates
            throw new \Exception("All content files must have a unique name.");
        }

        foreach ($files as $f) {
            return $this->contentFromFileCreator->createContentObject($f);
        }
    }

    public function findPostsContainingAttributeValue($attribute, $targetValue)
    {
        $files = $this->finder
            ->files()
            ->in($this->contentPath);

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
        $refClass = new \ReflectionClass("\Skimpy\Entity\Content");
        $methods = $refClass->getMethods();
        foreach ($methods as $m) {
            # TODO: Just remove the get on the method names
            $isGetter = 'get' === substr($m->name, 0, 3);
            $getterContainsAttribute = false !== stripos($m->name, $attribute);
            if ($isGetter && $getterContainsAttribute) {
                return $m->name;
            }
        }
        throw new \Exception("\Skimpy\Entity\Content has no getter method for attribute '$attribute'.");
    }
}
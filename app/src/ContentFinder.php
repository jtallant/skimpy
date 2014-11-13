<?php namespace Skimpy;

use Symfony\Component\Finder\Finder;

class ContentFinder implements ContentFinderInterface
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
     * @return Skimpy\Content|null  If there is no file matching the given name, returns null
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
            throw new \RuntimeException("All content files must have a unique name.");
        }

        // Return the first item from the iterator that Symfony returns
        $this->contentFromFileCreator->createContentObject(current($files));
    }

    /**
     * @param string $attribute Attribute name
     * @param string|array $targetValue  The target value to search for
     * @return Skimpy\Entity\Content[]  Array of content items
     */
    public function findPostsContainingAttributeValue($attribute, $targetValue)
    {
        // Cast scalar types to array
        $targetValue = (array) $targetValue;
        
        $files = $this->finder
            ->files()
            ->in($this->contentPath);

        $getAttributeValue = $this->getGetterMethodForAttribute($attribute);
        $posts = [];
        foreach ($files as $f) {
            
            $content = $this->contentFromFileCreator->createContentObject($f);
            
            // If the content has the attribute we're looking for, and it matches or some values match...
            if (isset($content->$attribute) && array_intersect((array) $content->$attribute, $targetValue) > 0) {
                $posts[] = $content;
            }
        }

        return $posts;
    }
}
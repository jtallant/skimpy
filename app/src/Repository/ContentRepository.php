<?php namespace Skimpy\Repository;

use Symfony\Component\Finder\Finder;
use Skimpy\Contracts\RepositoryInterface;
use Skimpy\ContentFromFileCreator;
use Skimpy\Entity;

class ContentRepository implements RepositoryInterface
{
    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @var ContentFromFileCreator
     */
    protected $contentFromFileCreator;

    /**
     * @var string
     */
    protected $contentPath;

    /**
     * Constructor
     *
     * @param Finder                 $finder
     * @param ContentFromFileCreator $contentFromFileCreator
     * @param                        $contentPath
     *
     * @throws \Exception
     */
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
     * @param array $criteria
     */
    public function findBy(array $criteria)
    {
        if ($this->criteriaContains('slug', $criteria)) {
            return $this->findBySlug($criteria['slug']);
        }

        // must contain all of criteria


//
//        $files = $this->finder
//            ->files()
//            ->in($this->contentPath);
//
//        $items = [];
//        foreach ($files as $f) {
//            $content = $this->contentFromFileCreator->createContentObject($f);
//
//            if (isset($content->$attribute) && array_intersect((array) $content->$attribute, $targetValue) > 0) {
//                $items[] = $content;
//            }
//        }
//        return $items;
    }

    protected function criteriaContains($value, array $criteria)
    {
        return array_key_exists($value, $criteria);
    }

    /**
     * Finds a post or page by slug.
     *
     * This is the file based finder so the slug is the name
     * of the file.
     *
     * @param string $slug name of the file without extension
     *
     * @return Entity\ContentItem|null If there is no file matching the given name, returns null
     */
    protected function findBySlug($slug)
    {
        $files = $this->finder
            ->files()
            ->in($this->contentPath)
            ->name($slug.'.*');

        if (empty($files->count())) {
            return null;
        }

        if ($files->count() > 1) {
            # TODO: DuplicateContentFileNameException
            # List the file paths of the duplicates
            throw new \RuntimeException("All content files must have a unique name.");
        }

        foreach($files as $file) {
            return $this->contentFromFileCreator->createContentObject($file);
        }
    }

    /**
     * Finds content that has metadata matching key value
     *
     * @param string       $attribute
     * @param array|string $targetValue
     *
     * @return array contains Entity\ContentItem objects
     */
    protected function findPostsContainingAttributeValue($attribute, $targetValue)
    {
        $targetValue = (array) $targetValue;

        $files = $this->finder
            ->files()
            ->in($this->contentPath);

        $posts = [];
        foreach ($files as $f) {
            $content = $this->contentFromFileCreator->createContentObject($f);
            if (isset($content->$attribute) && array_intersect((array) $content->$attribute, $targetValue) > 0) {
                $posts[] = $content;
            }
        }
        return $posts;
    }
}
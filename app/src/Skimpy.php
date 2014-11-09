<?php namespace Skimpy;

class Skimpy {

    /**
     * @var Skimpy\ContentFinder
     */
    protected $contentFinder;

    /**
     * @var array
     */
    protected $validArchiveTypes = ['category', 'tag'];

    public function __construct(ContentFinder $contentFinder)
    {
        $this->contentFinder = $contentFinder;
    }

    public function find($slug)
    {
        return $this->contentFinder->findByName($slug);
    }

    public function findPostsInArchive($type, $name)
    {
        if (false === in_array($type, $this->validArchiveTypes)) {
            $validTypes = join(', ', $this->validArchiveTypes);
            throw new Exception("Invalid archive type $type. Valid types include $validTypes");
        }

        $attribute = 'category' === $type ? 'categories' : 'tags';

        return $this->contentFinder->findPostsContainingAttributeValue($attribute, $name);
    }

    public function archiveNameFromSlug($slug)
    {
        $name = str_replace('-', ' ', $slug);
        return ucwords($name);
    }
}
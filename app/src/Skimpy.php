<?php namespace Skimpy;

class Skimpy {

    /**
     * @var Skimpy\ContentFileFinder
     */
    protected $contentFileFinder;

    /**
     * @var array
     */
    protected $validArchiveTypes = ['category', 'tag'];

    public function __construct(ContentFileFinder $contentFileFinder)
    {
        $this->contentFileFinder = $contentFileFinder;
    }

    public function find($slug)
    {
        return $this->contentFileFinder->findByName($slug);
    }

    public function findPostsInArchive($type, $name)
    {
        if (false === in_array($type, $this->validArchiveTypes)) {
            $validTypes = join(', ', $this->validArchiveTypes);
            throw new Exception("Invalid archive type $type. Valid types include $validTypes");
        }

        $attribute = 'category' === $type ? 'categories' : 'tags';

        return $this->contentFileFinder->findPostsContainingAttributeValue($attribute, $name);
    }

    public function archiveNameFromSlug($slug)
    {
        $name = str_replace('-', ' ', $slug);
        return ucwords($name);
    }
}
<?php namespace Skimpy;

class Skimpy {

    protected $contentFileFinder;

    public function __construct(ContentFileFinder $contentFileFinder)
    {
        $this->contentFileFinder = $contentFileFinder;
    }

    public function find($slug)
    {
        $file = $this->contentFileFinder->findByName($slug);

        if (is_null($file)) {
            return null;
        }

        $content = ContentFromFileCreator::create($file);

        return $content;
    }

    public function findPostsInArchive($type, $name)
    {
        return [];
        // resourceType: category, tag
        // resourceName: web development, unix
    }
}
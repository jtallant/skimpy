<?php namespace Skimpy;

class Skimpy {

    protected $contentFileFinder;

    protected $validArchiveTypes = ['category', 'tag'];

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
        if (false === in_array($type, $this->validArchiveTypes)) {
            $validTypes = join(', ', $this->validArchiveTypes);
            throw new Exception("Invalid archive type $type. Valid types include $validTypes");
        }

        $files = $this->contentFileFinder->findPostsContaining($name);

        if ('category' === $type) {
            $getArchiveValues = 'getCategories';
        } else {
            $getArchiveValues = 'getTags';
        }

        $posts = [];
        foreach ($files as $f) {
            $content = ContentFromFileCreator::create($f);
            $archiveValues = array_map(
                function($value) {
                    return strtolower($value);
                },
                $content->$getArchiveValues()
            );

            if (in_array(strtolower($name), $archiveValues)) {
                $posts[] = $content;
            }
        }
        return $posts;
    }

    public function archiveNameFromSlug($slug)
    {
        $name = str_replace('-', ' ', $slug);
        return ucwords($name);
    }
}
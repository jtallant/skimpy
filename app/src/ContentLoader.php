<?php namespace Skimpy;

use Symfony\Component\Yaml;

class ContentLoader
{
    protected $contentDirectory;
    protected $pagesDirectory;
    protected $postsDirectory;

    const DEFAULT_EXTENSION = '.md';

    # TODO: Consider using pages and posts directories directly.
    public function __construct($contentDirectory)
    {
        $this->contentDirectory = $contentDirectory;
        $this->pagesDirectory   = $contentDirectory.'/pages';
        $this->postsDirectory   = $contentDirectory.'/posts';
    }

    public function load($slug)
    {
        $content = $this->findFromSlug($slug);
        return 'load content';
    }

    protected function findFromSlug($slug)
    {
        if (file_exists($this->pagePath($slug))) {
            $path = $this->pagePath($slug);
            $templateType = 'page';
        } elseif (file_exists($this->postPath($slug)) {
            $path = $this->postPath($slug);
            $templateType = 'post';
        } else {
            return null;
        }
    }

    protected function extractMetadata($filePath)
    {
        $rawFileContents = file_get_contents($filePath);
        list($yamlData, $contentData) = explode('----------', $rawFileContents, 2);

        // We load the contents of that into a twig template
        // and render it 
        $metadata = Yaml::parse($yamlData);        
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
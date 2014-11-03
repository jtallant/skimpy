<?php namespace Skimpy;

use Symfony\Component\Yaml\Yaml;

class ContentLoader
{
    protected $contentDirectory;
    protected $pagesDirectory;
    protected $postsDirectory;

    # TODO: Force .md and remove this?
    const DEFAULT_EXTENSION = '.md';

    const METADATA_SEPARATOR = '----------';

    # TODO: Consider using pages and posts directories directly.
    public function __construct($contentDirectory)
    {
        $this->contentDirectory = $contentDirectory;
        $this->pagesDirectory   = $contentDirectory.'/pages'; # Don't hardcode pages
        $this->postsDirectory   = $contentDirectory.'/posts'; # Don't hardcode posts
    }

    public function load($slug)
    {
        $filePath = $this->findFromSlug($slug);

        if (is_null($filePath)) {
            return null;
        }

        $resourceType = $this->determineResourceType($filePath);
        $rawContent = $this->rawContent($filePath);
        $metadata = $this->extractMetadata($rawContent);
        $content = $this->extractDisplayableContent($rawContent);
        return new Resource($metadata, $content, $resourceType);
    }

    protected function rawContent($filePath)
    {
        return file_get_contents($filePath);
    }

    protected function findFromSlug($slug)
    {
        if (file_exists($this->pagePath($slug))) {
            return $this->pagePath($slug);
        }

        if (file_exists($this->postPath($slug))) {
            return $this->postPath($slug);
        }

        return null;
    }

    protected function determineResourceType($filePath)
    {
        if (false !== stripos($filePath, '/posts/')) {
            return 'post';
        }

        return 'page';
    }

    protected function extractDisplayableContent($rawContent)
    {
        return explode(static::METADATA_SEPARATOR, $rawContent, 2)[1];
    }

    protected function extractMetadata($rawContent)
    {
        $yaml = explode(static::METADATA_SEPARATOR, $rawContent, 2)[0];
        return Yaml::parse($yaml);
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
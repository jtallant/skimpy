<?php namespace Skimpy\Repository;

use Symfony\Component\Finder\Finder;
use Skimpy\Contracts\ObjectRepository;
use Skimpy\Transformer\SplFileInfoToContentItem;

/**
 * Class ContentItem
 *
 * @package Skimpy\Repository
 */
class ContentItem extends Base implements ObjectRepository
{
    /**
     * @var \Skimpy\Transformer\SplFileInfoToContentItem
     */
    protected $transformer;

    /**
     * @var string
     */
    protected $contentPath;

    /**
     * Constructor
     *
     * @param Finder                   $finder
     * @param SplFileInfoToContentItem $transformer
     * @param string                   $contentPath
     */
    public function __construct(
        SplFileInfoToContentItem $transformer,
        $contentPath
    ) {
        $this->transformer = $transformer;
        $this->contentPath = $contentPath;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $objects = [];
        foreach ($this->getContentFiles() as $f) {
            $content = $this->transformer->transform($f);
            $objects[] = $content;
        }
        return $objects;
    }

    /**
     * @return Finder
     */
    protected function getContentFiles()
    {
        return (new Finder)->in($this->contentPath)->files();
    }
}
<?php namespace Skimpy\Transformer;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Parser;
use Michelf\Markdown;
use Skimpy\Entity\ContentItem;

class SplFileInfoToContentItem
{
    const METADATA_SEPARATOR = '----------';

    /**
     * @var SplFileInfoToMetadata
     */
    protected $metadataTransformer;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var Markdown
     */
    protected $markdown;

    /**
     * Constructor
     *
     * @param Parser   $parser
     * @param Markdown $markdown
     */
    public function __construct(
        SplFileInfoToMetadata $metadataTransformer,
        Parser $parser = null,
        Markdown $markdown = null
    ) {
        $this->metadataTransformer = $metadataTransformer;
        $this->parser = $parser ?: new Parser;
        $this->markdown = $markdown ?: new Markdown;
    }

    /**
     * Takes file data and returns a ContentItem object
     *
     * @param SplFileInfo $file
     *
     * @return ContentItem
     */
    public function transform(SplFileInfo $file)
    {
        $rawFileContents = $file->getContents();
        $metadata = $this->metadataTransformer->transform($file);
        $fullMetadata = $metadata->getFull();
        $displayableContent = $this->extractDisplayableContent($rawFileContents);

        $content = new ContentItem;
        $content
            ->setSlug($this->extractSlug($file))
            ->setTitle($fullMetadata['title'])
            ->setSeoTitle($fullMetadata['seotitle'])
            ->setDate($fullMetadata['date'])
            ->setMetadata($metadata)
            ->setContent($displayableContent)
            ->setExcerpt($this->extractExcerpt($fullMetadata, $displayableContent))
            ->setTemplate($fullMetadata['template'])
            ->setType($this->determineContentType($file->getPath()))
            ->setExtraProperties($metadata->getHydrated());

        return $content;
    }

    /**
     * Returns the filename without the extension
     *
     * @param SplFileInfo $file
     *
     * @return string
     */
    protected function extractSlug(SplFileInfo $file)
    {
        $exclude = '.'.$file->getExtension();
        return $file->getBasename($exclude);
    }

    /**
     * Returns the excerpt for the content
     *
     * @param array  $metadata
     * @param string $displayableContent
     *
     * @return string
     */
    protected function extractExcerpt(array $metadata, $displayableContent)
    {
        if (isset($metadata['excerpt'])) {
            return $metadata['excerpt'];
        }
        return strip_tags(substr($displayableContent, 0, 255));
    }

    /**
     * Determines the content type
     *
     * The content type is equal to the name of the direct
     * parent directory of the file.
     *
     * @param string $filePath
     *
     * @return string
     */
    protected function determineContentType($filePath)
    {
        return basename($filePath);
    }

    /**
     * Retrieves the non-metadata portion of the file
     *
     * @param string $rawFileContents
     *
     * @return string
     */
    protected function extractDisplayableContent($rawFileContents)
    {
        $content = explode(static::METADATA_SEPARATOR, $rawFileContents, 2)[1];
        return $this->markdown->transform($content);
    }
}
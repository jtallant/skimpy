<?php namespace Skimpy\Service;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Parser;
use Michelf\Markdown;
use Skimpy\Entity\ContentItem;

class ContentFromFileCreator
{
    const METADATA_SEPARATOR = '----------';

    const REQUIRED_METADATA = 'title|date';

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
        Parser $parser = null,
        Markdown $markdown = null
    ) {
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
    public function createContentObject(SplFileInfo $file)
    {
        $rawFileContents = $file->getContents();
        $rawMetadata = $this->parseMetadata($rawFileContents);
        $this->checkRawMetadataHasRequiredKeys($rawMetadata, $file->getRealPath());
        $metadata = $this->extractMetadata($rawMetadata);
        $displayableContent = $this->extractDisplayableContent($rawFileContents);
        $viewData = $metadata;
        $viewData['content'] = $displayableContent;

        $content = new ContentItem;
        $content
            ->setSlug($this->extractSlug($file))
            ->setTitle($metadata['title'])
            ->setSeoTitle($metadata['seotitle'])
            ->setDate($metadata['date'])
            ->setMetadata($metadata)
            ->setViewData($viewData)
            ->setContent($displayableContent)
            ->setExcerpt($this->extractExcerpt($metadata, $displayableContent))
            ->setTemplate($this->determineTemplate($metadata, $file->getPath()))
            ->setType($this->determineContentType($file->getPath()))
            ->setExtraProperties($metadata);

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
     * Determines which template to use to render the content
     *
     * The template defaults to whatever content type of
     * the content is (page or post).
     *
     * The template can be overridden in the metadata.
     *
     * @param array  $metadata
     * @param string $filePath
     *
     * @return string
     */
    protected function determineTemplate(array $metadata, $filePath)
    {
        $metadataContainsTemplate = false === empty($metadata['template']);
        $template = $metadataContainsTemplate
            ? $metadata['template']
            : $this->determineContentType($filePath);

        # TODO: MissingTemplateForContentTypeException
        # if template file doesn't exist
        # throw exception
        return $template;
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
     * Throws an exception if required metadata is missing
     *
     * @param array  $rawMetadata
     * @param string $filePath
     *
     * @return void
     */
    protected function checkRawMetadataHasRequiredKeys(array $rawMetadata, $filePath)
    {
        foreach ($this->getRequiredMetadata() as $key) {
            if (false === array_key_exists($key, $rawMetadata)) {
                throw new \Exception("$filePath is missing required metadata key $key.");
            }
            if (empty($rawMetadata[$key])) {
                throw new \Exception("$filePath requires a value for metadata key $key.");
            }
        }
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

    /**
     * Retrieves the metadata in array format
     *
     * @param string $rawFileContents
     *
     * @return string
     */
    protected function parseMetadata($rawFileContents)
    {
        $yaml = explode(static::METADATA_SEPARATOR, $rawFileContents, 2)[0];
        return $this->parser->parse($yaml);
    }

    /**
     * Formats the metadata, fills in fallback for optional keys
     *
     * @param array $rawMetadata
     *
     * @return array formatted metadata
     */
    protected function extractMetadata(array $rawMetadata)
    {
        $formattedMetadata = $this->formatRawMetadata($rawMetadata);
        return $this->fillDefaultMetadataValues($formattedMetadata);
    }

    /**
     * Formats the raw metadata and returns it
     *
     * @param array $rawMetadata
     *
     * @return array formatted metadata
     */
    protected function formatRawMetadata(array $rawMetadata)
    {
        $metadata = $rawMetadata;
        $dt = new \DateTime;
        $dt->setTimestamp($metadata['date']);
        $metadata['date'] = $dt;
        return $metadata;
    }

    /**
     * Populates optional keys with their fallback if there is one
     *
     * @param array $metadata
     *
     * @return array metadata with fallback key values
     */
    protected function fillDefaultMetadataValues(array $metadata)
    {
        if (empty($metadata['seotitle'])) {
            $metadata['seotitle'] = $metadata['title'];
        }
        return $metadata;
    }

    /**
     * Returns an array of required metadata keys
     *
     * @return array
     */
    protected function getRequiredMetadata()
    {
        return explode('|', static::REQUIRED_METADATA);
    }
}
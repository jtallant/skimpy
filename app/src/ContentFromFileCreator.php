<?php namespace Skimpy;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;
use Michelf\Markdown;

# Maybe make an interface called ContentCreator
# and call this ContentFromFileCreator?
# How to do this without knowing what the other implementations
# would take in their create method?
class ContentFromFileCreator
{
    const METADATA_SEPARATOR = '----------';

    const REQUIRED_METADATA = 'title|date';

    const MARKDOWN_EXTENSIONS = 'markdown|mdown|mkdn|md|mkd|mdwn|mdtxt|mdtext|text';

    /**
     * @var Symfony\Component\Finder\SplFileInfo
     */
    protected $file;

    /**
     * @var string
     */
    protected $rawFileContents;

    /**
     * @var array
     */
    protected $rawMetadata;

    /**
     * @var array
     */
    protected $metadata;

    /**
     * @var string
     */
    protected $displayableContent;

    protected function __construct(SplFileInfo $file)
    {
        $this->file = $file;
        $this->rawFileContents = $file->getContents();
        $this->rawMetadata = $this->parseMetadata();
        $this->checkRawMetadataHasRequiredKeys();
        $this->metadata = $this->extractMetadata();
        $this->displayableContent = $this->extractDisplayableContent();
    }

    public static function create(SplFileInfo $file)
    {
        return (new static($file))->createContentObject();
    }

    /**
     * @return \Skimpy\Content
     */
    protected function createContentObject()
    {
        $content = new Content;
        $content
            ->setTitle($this->metadata['title'])
            ->setSeoTitle($this->metadata['seotitle'])
            ->setDate($this->metadata['date'])
            ->setMetadata($this->metadata)
            ->setViewData($this->extractViewData())
            ->setDisplayableContent($this->displayableContent)
            ->setExcerpt($this->extractExcerpt())
            ->setTemplate($this->determineTemplate())
            ->setType($this->determineContentType());

        if (false === empty($this->metadata['categories'])) {
            $content->setCategories($this->metadata['categories']);
        }

        if (false === empty($this->metadata['tags'])) {
            $content->setTags($this->metadata['tags']);
        }

        return $content;
    }

    protected function extractViewData()
    {
        $data = $this->metadata;
        $data['content'] = $this->displayableContent;
        return $data;
    }

    protected function extractExcerpt()
    {
        if (isset($this->metadata['excerpt'])) {
            return $this->metadata['excerpt'];
        }

        $content = $this->displayableContent;
        return strip_tags(substr($content, 0, 255));
    }

    /**
     * Determines which template to use to render the content
     *
     * The template defaults to whatever content type of
     * the content is (page or post).
     *
     * The template can be overriden in the metadata.
     *
     * @return string
     */
    protected function determineTemplate()
    {
        if (false === empty($this->metadata['template'])) {
            # TODO: Check template file exists
            # or don't and just let twig throw the exception
            return $this->metadata['template'];
        }

        return $this->determineContentType();
    }

    protected function determineContentType()
    {
        $filePath = $this->file->getRealPath();

        if (false !== stripos($filePath, '/posts/')) {
            return 'post';
        }

        if (false !== stripos($filePath, '/pages/')) {
            return 'page';
        }

        # The type is based on the directory it lives in
        # The type is used to determine what template to render it into
        # TODO: Find a way to be more clear about this.
        throw new \Exception("Cannot determine content type from path $filePath");
    }

    protected function checkRawMetadataHasRequiredKeys()
    {
        $filePath = $this->file->getRealPath();
        foreach ($this->requiredMetadata() as $key) {
            if (false === array_key_exists($key, $this->rawMetadata)) {
                throw new \Exception("$filePath is missing required metadata key $key.");
            }
            if (empty($this->rawMetadata[$key])) {
                throw new \Exception("$filePath requires a value for metadata key $key.");
            }
        }
    }

    protected function extractDisplayableContent()
    {
        $content = explode(static::METADATA_SEPARATOR, $this->rawFileContents, 2)[1];

        if ($this->hasMarkdownExtension()) {
            return Markdown::defaultTransform($content);
        }

        return $content;
    }

    protected function hasMarkdownExtension()
    {
        return in_array($this->file->getExtension(), $this->markdownExtensions());
    }

    protected function parseMetadata()
    {
        $yaml = explode(static::METADATA_SEPARATOR, $this->rawFileContents, 2)[0];
        return Yaml::parse($yaml);
    }

    protected function extractMetadata()
    {
        $formattedMetadata = $this->formatRawMetadata();
        return $this->fillDefaultMetadataValues($formattedMetadata);
    }

    protected function formatRawMetadata()
    {
        $metadata = $this->rawMetadata;
        $dt = new \DateTime;
        $dt->setTimestamp($metadata['date']);
        $metadata['date'] = $dt;
        return $metadata;
    }

    protected function fillDefaultMetadataValues($metadata)
    {
        if (empty($metadata['seotitle'])) {
            $metadata['seotitle'] = $metadata['title'];
        }
        return $metadata;
    }

    protected function markdownExtensions()
    {
        return explode('|', static::MARKDOWN_EXTENSIONS);
    }

    protected function requiredMetadata()
    {
        return explode('|', static::REQUIRED_METADATA);
    }
}
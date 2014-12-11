<?php namespace Skimpy\Transformer;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Parser;
use Skimpy\Repository\ContentType;
use Skimpy\Metadata;

class SplFileInfoToMetadata
{
    const REQUIRED_METADATA = 'title|date';

    /**
     * @var ContentType
     */
    protected $contentTypeRepository;

    public function __construct(ContentType $contentTypeRepository, Parser $parser = null)
    {
        $this->contentTypeRepository = $contentTypeRepository;
        $this->parser = $parser ?: new Parser;
    }

    public function transform(SplFileInfo $file)
    {
        $rawFileContents = $file->getContents();
        $rawMetadata = $this->parseMetadata($rawFileContents);
        $this->checkRawMetadataHasRequiredKeys($rawMetadata, $file->getRealPath());

        $formattedMetadata = $this->formatRawMetadata($rawMetadata);
        $fullMetadata = $this->fillDefaultMetadataValues($formattedMetadata, $file->getPath());

        $metadata = new Metadata;
        $metadata
            ->setRaw($rawMetadata)
            ->setFull($fullMetadata)
            ->setHydrated($this->hydrateTerms($fullMetadata));

        return $metadata;
    }

    /**
     * Populates optional keys with their fallback if there is one
     *
     * @param array $metadata
     *
     * @return array metadata with fallback key values
     */
    protected function fillDefaultMetadataValues(array $metadata, $filePath)
    {
        if (empty($metadata['seotitle'])) {
            $metadata['seotitle'] = $metadata['title'];
        }

        if (empty($metadata['template'])) {
            $metadata['template'] = basename($filePath);
        }

        // TODO: Extract
        $contentTypes = $this->contentTypeRepository->findAll();
        foreach ($contentTypes as $type) {
            $typeKey = $type->getKey();
            if (empty($metadata[$typeKey])) {
                $metadata[$typeKey] = [];
            }
        }

        return $metadata;
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

    // If an extra property is a "ContentType"
    // Set its value equal to its terms
    // Then in twig you can do..
    // for cat in categories
    //     cat.name, cat.slug, etc.
    // endfor
    // TODO: Refactor
    protected function hydrateTerms(array $metadata)
    {
        foreach ($metadata as $k => $v) {
            $criteria = [
                'key' => $k
            ];

            $contentType = $this->contentTypeRepository->findOneBy($criteria);

            if (false === is_null($contentType)) {
                $metadataTerms = $v;
                $terms = $contentType->getTerms();
                $metadata[$k] = [];

                foreach ($terms as $t) {
                    if (in_array($t->getName(), $metadataTerms)) {
                        $metadata[$k][] = $t;
                    }
                }
            }
        }
        return $metadata;
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
     * Returns an array of required metadata keys
     *
     * @return array
     */
    protected function getRequiredMetadata()
    {
        return explode('|', static::REQUIRED_METADATA);
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
        $yaml = explode(SplFileInfoToContentItem::METADATA_SEPARATOR, $rawFileContents, 2)[0];
        return $this->parser->parse($yaml);
    }
}
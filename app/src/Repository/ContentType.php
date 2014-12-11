<?php namespace Skimpy\Repository;

use Skimpy\Contracts\ObjectRepository;
use Skimpy\Transformer\ArrayToContentType;

/**
 * Class ContentType
 *
 * @package Skimpy\Repository
 */
class ContentType extends Base implements ObjectRepository
{
    /**
     * @var array
     */
    protected $contentTypes;

    /**
     * @var ArrayToContentType
     */
    protected $transformer;

    # TODO: Docblocks
    public function __construct(array $contentTypes, ArrayToContentType $transformer) {
        $this->contentTypes = $contentTypes;
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $objects = [];
        foreach ($this->contentTypes as $type) {
            $objects[] = $this->transformer->transform($type);
        }
        return $objects;
    }
}
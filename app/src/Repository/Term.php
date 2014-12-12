<?php namespace Skimpy\Repository;

use Skimpy\Contracts\ObjectRepository;
use Skimpy\Transformer\ArrayToContentType;

class Term extends Base implements ObjectRepository
{
    /**
     * @var array
     */
    protected $contentTypes;

    /**
     * @var ArrayToContentType
     */
    protected $transformer;

    public function __construct(array $contentTypes, ArrayToContentType $transformer)
    {
        $this->contentTypes = $contentTypes;
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $terms = [];
        foreach ($this->contentTypes as $type) {
            $contentType = $this->transformer->transform($type);
            $terms = array_merge($terms, $contentType->getTerms());
        }
        return $terms;
    }
}
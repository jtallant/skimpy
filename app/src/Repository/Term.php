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

    /**
     * @var ContentItem
     */
    protected $contentItemRepository;

    public function __construct(
        array $contentTypes,
        ArrayToContentType $transformer,
        ContentItem $contentItemRepository
    ) {
        $this->contentTypes = $contentTypes;
        $this->transformer = $transformer;
        $this->contentItemRepository = $contentItemRepository;
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

        foreach ($terms as $term) {
            $items = $this->getTermItems($term);
            $term->setItems($items);
        }

        return $terms;
    }

    protected function getTermItems($term)
    {
        $criteria = [
            $term->getContentTypeKey() => $term->getName()
        ];

        return $this->contentItemRepository->findBy($criteria);
    }
}
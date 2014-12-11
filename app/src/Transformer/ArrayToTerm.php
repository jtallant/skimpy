<?php namespace Skimpy\Transformer;

use Skimpy\Entity\Term;
use Skimpy\Repository\ContentItem;

class ArrayToTerm
{
    /**
     * @var ContentItem
     */
    protected $contentItemRepository;

    public function __construct(ContentItem $contentItemRepository)
    {
        $this->contentItemRepository = $contentItemRepository;
    }

    public function transform(array $data)
    {
        return (new Term)
            ->setContentTypeKey($data['contentTypeKey'])
            ->setName($data['name'])
            ->setSlug($data['slug'])
            ->setItems($this->getItems($data['contentTypeKey'], $data['name']));
    }

    protected function getItems($contentTypeKey, $termName)
    {
        $criteria = [$contentTypeKey => $termName];
        return $this->contentItemRepository->findBy($criteria);
    }
}
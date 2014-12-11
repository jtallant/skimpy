<?php namespace Skimpy\Transformer;

use Skimpy\Entity\ContentType;
use Skimpy\Transformer\ArrayToTerm;

class ArrayToContentType
{
    /**
     * @var ArrayToTerm
     */
    protected $termTransformer;

    public function __construct(ArrayToTerm $termTransformer)
    {
        $this->termTransformer = $termTransformer;
    }

    public function transform(array $data)
    {
        return (new ContentType)
            ->setKey($data['key'])
            ->setName($data['name'])
            ->setPluralName($data['plural_name'])
            ->setSlug($data['slug'])
            ->setTerms($this->transformTerms($data['terms'], $data['key']));
    }

    protected function transformTerms(array $terms, $contentTypeKey)
    {
        $termObjects = [];
        foreach ($terms as $term) {
            $term['contentTypeKey'] = $contentTypeKey;
            $termObjects[] = $this->termTransformer->transform($term);
        }
        return $termObjects;
    }
}
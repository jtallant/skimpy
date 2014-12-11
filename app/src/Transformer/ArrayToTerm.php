<?php namespace Skimpy\Transformer;

use Skimpy\Entity\Term;

class ArrayToTerm
{
    public function transform(array $data)
    {
        return (new Term)
            ->setContentTypeKey($data['contentTypeKey'])
            ->setName($data['name'])
            ->setSlug($data['slug']);
    }
}
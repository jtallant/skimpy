<?php namespace Skimpy\Entity;

use Skimpy\Behavior\ReadableProperties;

/**
 * Class Term
 *
 * @package Skimpy\Entity
 */
class Term
{
    /**
     * @var string
     */
    protected $contentTypeKey;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var array
     */
    protected $items;

    /**
     * Makes properties with public getters publicly readable
     */
    use ReadableProperties;

    public function getContentTypeKey()
    {
        return $this->contentTypeKey;
    }

    public function setContentTypeKey($contentTypeKey)
    {
        $this->contentTypeKey = $contentTypeKey;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
        return $this;
    }
}
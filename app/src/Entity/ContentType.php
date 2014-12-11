<?php namespace Skimpy\Entity;

use Skimpy\Behavior\ReadableProperties;

/**
 * Class ContentType
 *
 * @package Skimpy\Entity
 */
class ContentType
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $pluralName;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var array
     */
    protected $terms;

    use ReadableProperties;

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPluralName()
    {
        return $this->pluralName;
    }

    /**
     * @param string $pluralName
     *
     * @return $this
     */
    public function setPluralName($pluralName)
    {
        $this->pluralName = $pluralName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return array
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @param array $terms
     *
     * @return $this
     */
    public function setTerms(array $terms)
    {
        $this->terms = $terms;
        return $this;
    }
}
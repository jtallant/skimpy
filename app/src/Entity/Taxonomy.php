<?php namespace Skimpy\Entity;

/**
 * Class Taxonomy
 *
 * category, tag, product-type, etc
 *
 * @package Skimpy\Entity
 */
class Taxonomy
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * Get name
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function slug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
}
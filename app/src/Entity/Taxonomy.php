<?php namespace Skimpy\Entity;

# A thing like a category, tag, product-type, genre
class Taxonomy
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var slug
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
     * @return Skimpy\Entity\Taxonomy
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
     * @param string slug
     *
     * @return Skimpy\Entity\Taxonomy
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
}
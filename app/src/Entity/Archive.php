<?php namespace Skimpy\Entity;

class Archive
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var slug
     */
    protected $slug;

    public function name()
    {
        return $this->name;
    }

    public function slug()
    {
        return $this->slug;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
}
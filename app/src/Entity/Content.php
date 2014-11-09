<?php namespace Skimpy\Entity;

class Content
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $seoTitle;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var array
     */
    protected $categories = [];

    /**
     * @var array
     */
    protected $tags = [];

    /**
     * @var array
     */
    protected $metadata = [];

    /**
     * @var array
     */
    protected $viewData = [];

    /**
     * @var string
     */
    protected $displayableContent;

    /**
     * @var string
     */
    protected $excerpt;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    protected $type;

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getSeotitle()
    {
        return $this->seotitle;
    }

    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        if (is_array($categories)) {
            $this->categories = $categories;
        } elseif (is_string($categories)) {
            $this->categories = array_map('trim', explode(',', $categories));
        } else {
            throw new \Exception('Invalid value for categories');
        }
        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        if (is_array($tags)) {
            $this->tags = $tags;
        } elseif (is_string($tags)) {
            $this->tags = array_map('trim', explode(',', $tags));
        } else {
            throw new \Exception('Invalid value for tags');
        }
        return $this;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function getViewData()
    {
        return $this->viewData;
    }

    public function setViewData(array $viewData)
    {
        $this->viewData = $viewData;
        return $this;
    }

    public function getDisplayableContent()
    {
        return $this->displayableContent;
    }

    public function setDisplayableContent($displayableContent)
    {
        $this->displayableContent = $displayableContent;
        return $this;
    }

    public function getExcerpt()
    {
        return $this->excerpt;
    }

    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
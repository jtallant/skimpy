<?php namespace Skimpy\Entity;

use DateTime;
use Skimpy\Behavior\ReadableProperties;

/**
 * Class ContentItem
 *
 * @package Skimpy\Entity
 */
class ContentItem
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
    protected $content;

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

    /**
     * Makes properties with public getters publicly readable
     */
    use ReadableProperties;

    /**
     * Returns the slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Returns the slug
     *
     * @param $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Returns the seoTitle
     *
     * @return mixed
     */
    public function getSeotitle()
    {
        return $this->seotitle;
    }

    /**
     * Sets the seoTitle
     *
     * @param $seoTitle
     *
     * @return $this
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;
        return $this;
    }

    /**
     * Returns the date
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date
     *
     * @param DateTime $date
     *
     * @return $this
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Returns the categories
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param $categories
     *
     * @return $this
     * @throws \Exception
     */
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

    /**
     * Returns the tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Sets the tags
     *
     * @param $tags
     *
     * @return $this
     * @throws \Exception
     */
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

    /**
     * Returns the metadata
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Sets the metadata
     *
     * @param array $metadata
     *
     * @return $this
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * Returns the view data
     *
     * @return array
     */
    public function getViewData()
    {
        return $this->viewData;
    }

    /**
     * Sets the view data array
     *
     * @param array $viewData
     *
     * @return $this
     */
    public function setViewData(array $viewData)
    {
        $this->viewData = $viewData;
        return $this;
    }

    /**
     * Returns the displayable content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the displayableContent
     *
     * @param $displayableContent
     *
     * @return $this
     */
    public function setContent($displayableContent)
    {
        $this->content = $displayableContent;
        return $this;
    }

    /**
     * Returns the excerpt
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Sets the excerpt
     *
     * @param $excerpt
     *
     * @return $this
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
        return $this;
    }

    /**
     * Returns the template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Sets the template
     *
     * @param $template
     *
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Returns the type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type (post, page, etc)
     *
     * @param $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
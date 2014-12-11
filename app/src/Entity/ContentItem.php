<?php namespace Skimpy\Entity;

use DateTime;
use Skimpy\Behavior\ReadableProperties;
use Skimpy\Metadata;

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
     * @var Metadata
     */
    protected $metadata;

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
        return $this->seoTitle;
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
     * Returns the metadata
     *
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Sets the metadata
     *
     * @param Metadata $metadata
     *
     * @return $this
     */
    public function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;
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

    /**
     * Sets extra properties on the object
     *
     * Keys will be used as property name, values as values
     *
     * @param array $properties
     *
     * @return $this
     */
    public function setExtraProperties(array $properties)
    {
        foreach ($properties as $prop => $value) {
            if (false === isset($this->$prop)) {
                $this->$prop = $value;
            }
        }
        return $this;
    }
}
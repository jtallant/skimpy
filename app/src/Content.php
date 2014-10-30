<?php namespace Skimpy;

class Content
{
    protected $type;
    protected $title;
    protected $seoTitle;
    protected $date;
    protected $categories;
    protected $tags;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function metadata()
    {
        return [
            'type'       => $this->type,
            'title'      => $this->title,
            'seoTitle'   => $this->seoTitle,
            'date'       => $this->date,
            'categories' => $this->categories,
            'tags'       => $this->tags
        ];
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getTags()
    {
        return $this->tags;
    }
}
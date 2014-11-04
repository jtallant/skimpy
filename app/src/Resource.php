<?php namespace Skimpy;

/*
    This class has been replaced by the Content class.
    I'm keeping it here for discussion for now.

    This is an example where the content sets its own properties
    given some parameters through the constructor.

    The new content class has public setters and is not responsible
    for setting its own properties.
*/
class Resource
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $seotitle;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var array
     */
    protected $categories;

    /**
     * @var array
     */
    protected $tags;

    /**
     * @var array
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

    # Consider taking the path to the file as the only param
    # Figure everything else out from there
    public function __construct(array $metadata, $content, $type)
    {
        $this->metadata = $metadata;
        $this->content = $content;
        $this->type = $type;
        $this->setProperties();
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function getViewData()
    {
        $data = $this->metadata;
        $data['content'] = $this->getContent();
        return $data;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSeotitle()
    {
        return $this->seotitle;
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

    public function getContent()
    {
        return $this->content;
    }

    public function getExcerpt()
    {
        return $this->excerpt;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    protected function setTitle($title)
    {
        $this->title = $title;
    }

    protected function setSeotitle($seotitle)
    {
        $this->seotitle = $seotitle;
    }

    protected function setDate($date)
    {
        if (is_int($date)) {
            $dt = new \DateTime;
            $dt->setTimestamp($date);
            $this->date = $dt;
        } elseif ($date instanceof \DateTime) {
            $this->date = $date;
        } elseif (is_string($date)) {
            $this->date = new \DateTime($date);
        } else {
            throw new \Exception('Invalid value for date');
        }
    }

    protected function setCategories($categories)
    {
        if (is_array($categories)) {
            $this->categories = $categories;
        } elseif (is_string($categories)) {
            $this->categories = array_map('trim', explode(',', $categories));
        } else {
            throw new \Exception('Invalid value for categories');
        }
    }

    protected function setTags($tags)
    {
        if (is_array($tags)) {
            $this->tags = $tags;
        } elseif (is_string($tags)) {
            $this->tags = array_map('trim', explode(',', $tags));
        } else {
            throw new \Exception('Invalid value for tags');
        }
    }

    protected function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    }

    protected function setTemplate($template)
    {
        $this->template = $template;
    }

    protected function buildExcerpt()
    {
        # get the first n chars of the content
        # strip it and set is as the excerpt
    }

    protected function setProperties()
    {
        foreach ($this->metadata as $k => $v) {
            if (false === property_exists($this, $k)) {
                throw new \Exception("Invalid property $k");
            }
            $setProp = 'set'.ucfirst($k);
            $this->$setProp($v);
        }

        if (is_null($this->template)) {
            $this->template = $this->type;
        }

        if (is_null($this->excerpt)) {
            $this->excerpt = $this->buildExcerpt();
        }
    }
}
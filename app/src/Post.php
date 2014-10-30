<?php namespace Skimpy;

class Post extends Resource {

    protected $title;

    protected $seotitle;

    protected $date;

    protected $categories;

    protected $tags;

    protected $app;

    protected $type;

    protected $key;

    public function __construct($key, $app)
    {
        $data = $this->app['posts'][$key];

        $this->app        = $app;
        $this->key        = $key;
        $this->title      = $data['title'];
        $this->seotitle   = isset($data['seotitle'])   ? $data['seotitle'] : $data['title'];
        $this->date       = isset($data['date'])       ? $this->formatDate($data['date']) : '';
        $this->categories = isset($data['categories']) ? $data['categories'] : [];
        $this->tags       = isset($data['tags'])       ? $data['tags'] : [] ;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function pluralType()
    {
        return 'posts';
    }
}
<?php namespace Skimpy;

class Skimpy {

    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function getResource($slug)
    {
        if ($this->isPost($slug)) {
            $resource = new Post($slug, $this->app);
        }

        if ($this->isPage($slug)) {
            $resource = new Page($slug, $this->app);
        }

        if (isset($resource)) {
            return $resource;
        }

        return false;
    }

    public function isPage($slug)
    {
        return isset($this->app['pages'][$slug]);
    }

    public function isPost($slug)
    {
        return isset($this->app['posts'][$slug]);
    }
}
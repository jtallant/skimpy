<?php namespace Skimpy;

abstract class Resource {

    abstract function pluralType();

    abstract function getKey();

    public function getTemplate()
    {
        return $this->pluralType().'/'.$this->getKey().'.twig';
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSeoTitle()
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

    protected function formatDate($date)
    {
        return date($this->app['site.date_format'], strtotime($date));
    }
}
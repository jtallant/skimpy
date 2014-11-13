<?php

namespace Skimpy\Entity;

class ContentTaxonomyItem
{
    /**
     * Constructor
     * 
     * @param Taxonomy $taxonomy
     * @param Content $term
     * @param string $term
     */
    public function __construct(Taxonomy $taxonomy, Content $content, $term)
    {
        $this->taxonomy = $taxonomy;
        $this->content  = $content;
        $this->term     = $term;
    }
    
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }
    
    public function getTerm()
    {
        return $this->term;
    }
    
    public function __toString()
    {
        return $this->getTerm();
    }
}
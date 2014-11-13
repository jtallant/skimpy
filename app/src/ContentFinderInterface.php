<?php

namespace Skimpy;

/**
 * Content Finder Interface
 */
interface ContentFinderInterface
{
    /**
     * Find post by name
     * 
     * @param string
     * @return Content|null
     */
    function findByName($name);
    
    /**
     * Find posts containing an attribute
     * 
     * @param string $attribute
     * @param string|array $targetValue
     * @return array
     */
    function findPostsContainingAttributeValue($attribute, $targetValue);
}
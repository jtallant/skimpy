<?php

namespace Skimpy;

class MongoContentFinder implements ContentFinderInterface
{
    public function __constructor(MongoConnector $mongo)
    {
        $this->mongo = $mongo;
    }
    
    /**
     * Find post by name
     * 
     * @param string
     * @return Content|null
     */
    public function findByName($name)
    {
        $rawContent = $this->mongo->query({'name': $name});
        
        if ($rawContent) {
            return $this->convertRaWContentToContent($rawContent);    
        }
        else {
            return null;
        }
        
    }
    
    /**
     * Find posts containing an attribute
     * 
     * @param string $attribute
     * @param string|array $targetValue
     * @return array
     */
    public function findPostsContainingAttributeValue($attribute, $targetValue)    
    {
        // you get the idea...
    }
}

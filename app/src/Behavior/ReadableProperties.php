<?php namespace Skimpy\Behavior;

/**
 * Class ReadableProperties
 *
 * @package Skimpy\Behavior
 */
trait ReadableProperties {

    /**
     * Get magic method
     *
     * Allows pseudo-public access to properties that have a getter.
     * In other words it allows "Attribute Readers".
     *
     * @return mixed
     */
    public function __get($property)
    {
        $methodName = 'get' . ucfirst($property);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
    }

    /**
     * Is property existent from a public standpoint outside the class?
     *
     * @return boolean
     */
    public function __isset($item)
    {
        $methodName = 'get' . ucfirst($item);
        return method_exists($this, $methodName);
    }
}
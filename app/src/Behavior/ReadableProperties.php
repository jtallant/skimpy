<?php namespace Skimpy\Behavior;

/**
 * Trait ReadableProperties
 *
 * A property is considered readable if it is set
 * and has a public getter method. A readable property
 * is useful because it is publicly accessible on an instance
 * without calling the getter method.
 *
 * Getter method names must follow some conventions:
 * 1. Prefixed with 'get'
 * 2. The property name comes right after 'get' and is in StudlyCase
 *
 * Property seoTitle would be a readable property if it is set
 * and has a getter named getSeoTitle().
 *
 * @package Skimpy\Behavior
 */
trait ReadableProperties
{
    /**
     * Get magic method
     *
     * Allows pseudo-public access to properties that have a getter.
     * In other words, it allows "Attribute Readers".
     *
     * @return mixed
     */
    public function __get($property)
    {
        $methodName = 'get' . ucfirst($property);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }

        $this->triggerUndefinedPropertyNotice($property);
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

    /**
     * @param string $propName
     *
     * @return void
     */
    protected function triggerUndefinedPropertyNotice($propName)
    {
        $class = __CLASS__;
        $message = "Attempting to access undefined property '$propName' ";
        $message .= "via __get() on class $class";
        trigger_error($message, E_USER_NOTICE);
    }
}
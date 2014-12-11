<?php namespace Skimpy;

use Skimpy\Behavior\ReadableProperties;

class Metadata
{
    /**
     * @var array
     */
    protected $raw;

    /**
     * @var array
     */
    protected $full;

    /**
     * @var array
     */
    protected $hydrated;

    use ReadableProperties;

    /**
     * @return array
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param array $raw
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
        return $this;
    }

    /**
     * @return array
     */
    public function getFull()
    {
        return $this->full;
    }

    /**
     * @param array $full
     */
    public function setFull($full)
    {
        $this->full = $full;
        return $this;
    }

    /**
     * @return array
     */
    public function getHydrated()
    {
        return $this->hydrated;
    }

    /**
     * @param array $hydrated
     */
    public function setHydrated($hydrated)
    {
        $this->hydrated = $hydrated;
        return $this;
    }
}
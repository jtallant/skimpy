<?php namespace Skimpy\Support;

use Illuminate\Support\Collection;

/**
 * Class SortedCollection
 *
 * @package Skimpy\Support
 */
class SortedCollection extends Collection
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @var array
     */
    protected $orderBy;

    /**
     * @param array     $items   array of objects
     * @param array     $orderBy format ['propertyName' => 'direction'], direction is ASC or DESC
     * @param int|null  $limit   limits the number of items
     * @param int|null  $offset  removes the first n items
     *
     * @throws \Exception
     */
    public function __construct(array $items, array $orderBy = null, $limit = null, $offset = null)
    {
        $this->items = $items;
        $this->orderBy = is_null($orderBy) ? ['date' => 'DESC'] : $orderBy;

        if ($this->isInvalidDirection()) {
            # TODO: Better exception
            $direction = $this->getOrderByDirection();
            throw new \Exception("Invalid direction for orderBy: $direction");
        }

        $this->order();
        $this->items = $this->take($limit)->items;
        $this->offset($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        return new parent(array_slice($this->items, $offset, $length, $preserveKeys));
    }

    /**
     * {@inheritDoc}
     */
    public function splice($offset, $length = 0, $replacement = array())
    {
        return new parent(array_splice($this->items, $offset, $length, $replacement));
    }

    /**
     * Orders the items according to $orderBy
     *
     * @return $this
     */
    protected function order()
    {
        if ($this->isDescending()) {
            return $this->sortByDesc($this->getOrderByValue());
        }
        return $this->sortBy($this->getOrderByValue());
    }

    /**
     * Offsets the items by $offset
     *
     * @param null $offset
     *
     * @return $this
     */
    protected function offset($offset = null)
    {
        $this->items = is_null($offset)
            ? $this->items
            : $this->slice($offset)->items;
        return $this;
    }

    /**
     * Returns true if the orderBy direction is DESC
     *
     * @return bool
     */
    protected function isDescending()
    {
        return 'desc' == strtolower($this->getOrderByDirection());
    }

    /**
     * Returns true if the direction is not ASC or DESC
     *
     * @return bool
     */
    protected function isInvalidDirection()
    {
        return false === in_array(strtolower($this->getOrderByDirection()), $this->getValidDirections());
    }

    /**
     * Returns the orderBy direction
     *
     * @return mixed
     */
    protected function getOrderByDirection()
    {
        return array_values($this->orderBy)[0];
    }

    /**
     * Returns the property to order on
     *
     * @return mixed
     */
    protected function getOrderByValue()
    {
        return array_keys($this->orderBy)[0];
    }

    /**
     * Returns the valid directions we can sort with
     *
     * @return array
     */
    protected function getValidDirections()
    {
        return ['asc', 'desc'];
    }
}
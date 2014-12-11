<?php namespace Skimpy\Repository;

use Skimpy\Contracts\ObjectRepository;
use Skimpy\Support\SortedCollection;

abstract class Base implements ObjectRepository
{
    /**
     * {@inheritdoc}
     */
    abstract function findAll();

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $filteredItems = [];
        $items = $this->findAll();
        foreach ($items as $item) {
            if ($this->containsAllCriteria($item, $criteria)) {
                $filteredItems[] = $item;
            }
        }
        return (new SortedCollection($filteredItems, $orderBy, $limit, $offset))->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria)
    {
        $objects = $this->findBy($criteria);
        if (empty($objects)) {
            return null;
        }
        return $objects[0];
    }

    /**
     * Returns true if the $target object contains all the $criteria
     *
     * @param mixed $target
     * @param array $criteria
     *
     * @return bool
     */
    protected function containsAllCriteria($target, array $criteria)
    {
        foreach ($criteria as $prop => $value) {
            if (false === isset($target->$prop)) {
                return false;
            }

            if (false === $this->containsCriteria($target->$prop, $value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns true if target value contains criteria value
     *
     * @param mixed $targetValue
     * @param mixed $criteriaValue
     *
     * @return bool
     */
    protected function containsCriteria($targetValue, $criteriaValue)
    {
        $targetValue = (array) $targetValue;
        $criteriaValue = (array) $criteriaValue;
        return count(array_intersect($targetValue, $criteriaValue)) > 0;
    }
}
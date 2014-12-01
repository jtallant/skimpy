<?php namespace Skimpy\Contracts;

/**
 * Interface ObjectRepository
 *
 * @package Skimpy\Contracts
 */
interface ObjectRepository
{
    /**
     * Finds all objects in the repository.
     *
     * @return array The objects.
     */
    public function findAll();

    /**
     * Finds objects by a set of criteria.
     *
     * @param array $criteria
     *
     * @return array
     */
    public function findBy(array $criteria);

    /**
     * Finds a single object by a set of criteria.
     *
     * @param array $criteria The criteria.
     *
     * @return null|object The object.
     */
    public function findOneBy(array $criteria);
}
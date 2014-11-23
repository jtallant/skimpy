<?php namespace Skimpy\Contracts;

/**
 * Interface RepositoryInterface
 *
 * @package Skimpy\Contracts
 */
interface RepositoryInterface
{
    /**
     * Finds resource(s) by criteria
     *
     * @param array $criteria
     *
     * @return array|null
     */
    public function findBy(array $criteria);
}
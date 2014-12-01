<?php namespace Skimpy;

use Skimpy\Contracts\ObjectRepository;

/**
 * Class Skimpy
 *
 * @package Skimpy
 */
class Skimpy
{
    /**
     * @var ObjectRepository
     */
    protected $contentRepository;

    /**
     * Constructor
     *
     * @param ObjectRepository $contentRepository
     */
    public function __construct(ObjectRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    /**
     * Find ContentItem by slug
     *
     * @param $slug
     *
     * @return mixed
     */
    public function find($slug)
    {
        return $this->contentRepository->findOneBy(['slug' => $slug]);
    }

    /**
     * Finds content by criteria
     *
     * @param array $criteria
     *
     * @return null|Entity\ContentItem
     */
    public function findBy(array $criteria)
    {
        return $this->contentRepository->findBy($criteria);
    }
}
<?php namespace Skimpy;

use Skimpy\Contracts\RepositoryInterface;

/**
 * Class Skimpy
 *
 * @package Skimpy
 */
class Skimpy {

    /**
     * @var RepositoryInterface
     */
    protected $contentRepository;

    /**
     * Constructor
     *
     * @param RepositoryInterface $contentRepository
     */
    public function __construct(RepositoryInterface $contentRepository)
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
        return $this->contentRepository->findBy(['slug' => $slug]);
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
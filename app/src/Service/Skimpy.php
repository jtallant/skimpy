<?php namespace Skimpy\Service;

use Skimpy\Contracts\ObjectRepository;
use Skimpy\Entity\ContentItem;

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
     * Finds a ContentItem by slug
     *
     * @param $slug
     *
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return $this->contentRepository->findOneBy(['slug' => $slug]);
    }

    /**
     * Returns an array of ContentItems matching criteria
     *
     * @param array $criteria
     * @param array $orderBy
     * @param null  $limit
     * @param null  $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->contentRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param string $contentTypeSlug
     * @param string $termSlug
     *
     * @return array
     */
    public function getArchive($contentTypeSlug, $termSlug)
    {
        return [];
    }
}
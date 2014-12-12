<?php namespace Skimpy\Service;

use Skimpy\Contracts\ObjectRepository;
use Skimpy\Entity\Term;

/**
 * Class Skimpy
 *
 * This class is just a wrapper around the repositories.
 * It only exists to simplify the API.
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
     * @var ObjectRepository
     */
    protected $contentTypeRepository;

    /**
     * @var ObjectRepository
     */
    protected $termRepository;

    /**
     * Constructor
     *
     * @param ObjectRepository $contentRepository
     */
    public function __construct(
        ObjectRepository $contentRepository,
        ObjectRepository $contentTypeRepository,
        ObjectRepository $termRepository
    ) {
        $this->contentRepository = $contentRepository;
        $this->contentTypeRepository = $contentTypeRepository;
        $this->termRepository = $termRepository;
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
        $contentType = $this->contentTypeRepository->findOneBy(['slug' => $contentTypeSlug]);

        if (is_null($contentType)) {
            return null;
        }

        $term = $this->getTerm($contentType->getKey(), $termSlug);

        if (is_null($term)) {
            return null;
        }

        $contentItems = $this->getTermContentItems($term);
        $term->setItems($contentItems);

        return $term;
    }

    protected function getTerm($contentTypeKey, $termSlug)
    {
        return $this->termRepository->findOneBy(
            [
                'contentTypeKey' => $contentTypeKey,
                'slug' => $termSlug
            ]
        );
    }

    protected function getTermContentItems(Term $term)
    {
        return $this->contentRepository->findBy(
            [$term->getContentTypeKey() => $term->getName()]
        );
    }
}
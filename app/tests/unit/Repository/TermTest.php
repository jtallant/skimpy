<?php namespace Skimpy\Repository;

use Skimpy\BaseTestCase;

class TermTest extends BaseTestCase
{
    protected $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = $this->app['skimpy.repository.term'];
    }

    /** @test */
    public function it_finds_all_terms()
    {
        $terms = $this->repo->findAll();
        $contentTypes = $this->app['content_types'];
        $termsConfig = $this->getTerms($contentTypes);
        $this->assertEquals(count($termsConfig), count($terms));
    }

    protected function getTerms(array $contentTypes)
    {
        $terms = [];
        foreach ($contentTypes as $type) {
            $terms = array_merge($type['terms'], $terms);
        }
        return $terms;
    }
}
<?php namespace Skimpy\Repository;

use Skimpy\BaseTestCase;

class ContentItemTest extends BaseTestCase
{
    protected $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = $this->app['skimpy.repository.content_item'];
    }

    /** @test */
    function find_by_returns_empty_array_when_criteria_does_not_match()
    {
        $result = $this->repo->findBy(['slug' => 'non-existant-file']);
        $this->assertEmpty($result);
    }

    /** @test */
    function it_finds_content_items_by_criteria()
    {
        $contentItems = $this->repo->findBy(
            [
                'slug' => 'hello-world',
                'type' => 'post'
            ]
        );

        $this->assertCount(1, $contentItems);
    }
}
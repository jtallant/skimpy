<?php namespace Skimpy\Repository;

use Skimpy\BaseTestCase;

class ContentTypeTest extends BaseTestCase
{
    protected $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = $this->app['skimpy.repository.content_type'];
    }

    /** @test */
    public function it_finds_all_content_types()
    {
        $all = $this->repo->findAll();
        $this->assertCount(2, $all);
    }

    /** @test */
    public function it_returns_an_array()
    {
        $all = $this->repo->findAll();
        $this->assertTrue(is_array($all));
    }

    /** @test */
    public function it_contains_content_type_objects()
    {
        $objects = $this->repo->findAll();
        $this->assertTrue($objects[0] instanceof \Skimpy\Entity\ContentType);
    }

    /** @test */
    public function it_finds_content_types_by_criteria()
    {
        $criteria = [
            'key' => 'categories'
        ];

        $objects = $this->repo->findBy($criteria);
        $this->assertEquals(
            $objects[0]->getKey(),
            'categories'
        );
    }
}
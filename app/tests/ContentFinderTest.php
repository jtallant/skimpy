<?php

use Mockery as m;
use Skimpy\Repository\ContentItemRepository;
use Skimpy\ContentFromFileCreator;
use Symfony\Component\Finder\Finder;

class ContentFinderTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /** @test */
    function it_returns_null_when_no_file_with_matching_name_exists()
    {
        $finder = m::mock('Symfony\Component\Finder\Finder');
        $finder->shouldReceive('files->in->name')
            ->once()
            ->andReturn($finder);

        $finder->shouldReceive('count')
            ->once()
            ->andReturn(0);

        $contentFromFileCreator = m::mock(new ContentFromFileCreator);
        $contentPath = __DIR__.'/stubs/content';
        $contentFinder = new ContentItemRepository($finder, $contentFromFileCreator, $contentPath);
        $result = $contentFinder->findByName('non-existant-file.md');
        $this->assertNull($result);
    }

    /** @test */
    function it_finds_content_files_by_name()
    {
        $contentFromFileCreator = m::mock(new ContentFromFileCreator);
        $contentFromFileCreator->shouldReceive('createContentObject')->once();
        $contentFinder = new ContentItemRepository(new Finder, $contentFromFileCreator, __DIR__.'/stubs/content');
        $contentFinder->findByName('example-post');
    }
}
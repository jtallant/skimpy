<?php namespace Skimpy\Transformer;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Skimpy\BaseTestCase;

class SplFileInfoToContentItemTest extends BaseTestCase
{
    /** @test */
    public function it_converts_spl_file_info_to_a_content_item()
    {
        $path = $this->app['path.content'].'/page/about-me.md';
        $file = new SplFileInfo($path, '', '');
        $transformer = $this->app['skimpy.transformer.spl_file_info_to_content_item'];
        $contentItem = $transformer->transform($file);
        $this->assertInstanceOf('Skimpy\Entity\ContentItem', $contentItem);
    }
}
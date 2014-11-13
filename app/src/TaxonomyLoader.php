<?php namespace Skimpy;

use Symfony\Component\Yaml\Parser;

class TaxonomyLoader
{
    /**
     * @var Symfony\Component\Yaml\Parser
     */
    protected $parser;

    public function __construct(Parser $parser = null)
    {
        $this->parser = $parser ?: new Parser;
    }

    /**
     * Loads the taxonomies from the given file
     *
     * @return array
     */
    public function load($filePath)
    {
        $yaml = file_get_contents($filePath);
        return $this->parser->parse($yaml);
    }
}
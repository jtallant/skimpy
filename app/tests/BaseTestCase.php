<?php namespace Skimpy;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Skimpy\Application
     */
    protected $app;

    public function __construct()
    {
        global $app;
        $app['path.content'] = $app['path.base'].'/app/tests/data/content';
        $this->app = $app;
    }
}
<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I have a :arg1 file named :arg2
     */
    public function iHaveAFileNamed($arg1, $arg2)
    {
    }

    /**
     * @Given I provided :arg1 metadata as :arg2
     */
    public function iProvidedMetadataAs($arg1, $arg2)
    {
    }

    /**
     * @Given I provided :arg1 metadata including :arg2
     */
    public function iProvidedMetadataIncluding($arg1, $arg2)
    {
    }
}
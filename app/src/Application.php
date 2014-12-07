<?php namespace Skimpy;

use Silex\Application as Silex;
use Silex\Application\SwiftMailerTrait;
use Skimpy\Behavior\Twig;

class Application extends Silex
{
    use Twig;
    use SwiftmailerTrait;
}
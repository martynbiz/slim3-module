<?php

use MartynBiz\Slim3Module\Initializer;
use Slim\App;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Slim\App_mock
     */
    protected $appMock;

    /**
     * @var Composer\Autoload\ClassLoader_mock
     */
    protected $classLoaderMock;

    public function setUp()
    {
        // Create a mock renderer to pass to our Renderer, any will do
        $this->appMock = $this->getMockBuilder('Slim\App')
            ->disableOriginalConstructor()
            ->getMock();

        // Create a mock renderer to pass to our Renderer, any will do
        $this->classLoaderMock = $this->getMockBuilder('Composer\Autoload\ClassLoader')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function test_initialization()
    {
        $moduleInitializer = new Initializer($this->appMock, $this->classLoaderMock, [
            'autoload' => [],
        ]);

        $this->assertTrue($moduleInitializer instanceof Initializer);
    }
}

<?php

use MartynBiz\Slim3Module\Module;

use Slim\App;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Windwalker\Renderer\AbstractEngineRenderer_mock
     */
    protected $appMock;

    public function setUp()
    {
        // Create a mock renderer to pass to our Renderer, any will do
        $this->appMock = $this->getMockBuilder('Slim\\App')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function test_initialization()
    {
        $module = new Module($this->appMock);

        $this->assertTrue($module instanceof Module);
    }
}

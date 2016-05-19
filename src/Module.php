<?php
namespace MartynBiz\Slim3Module;

/**
 * This will load modules
 */
class Module
{
    /**
     * @var Slim
     */
    protected $app;

    /**
     * @var array
     */
    protected $settings;

    public function __construct($app, $settings=array())
    {
        $this->app = $app;
        $this->settings = $settings;
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function load($moduleName)
    {
        // get the path of the modules
        $modulePath = realpath($this->settings['modules_dir'] . '/' . $moduleName);

        // include the required module.php path of that module
        $app = $this->app;
        require $modulePath . '/module.php';
    }
}

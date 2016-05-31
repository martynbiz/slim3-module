<?php
namespace MartynBiz\Slim3Module;

use Composer\Autoload\ClassLoader;

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

     * @var ClassLoader
     */
    protected $classLoader;

    /**
     * @var array
     */
    protected $settings;

    public function __construct($app, ClassLoader $classLoader, $settings=array())
    {
        $this->app = $app;
        $this->classLoader = $classLoader;
        $this->settings = $settings;

        // load each module in $settings
        foreach($settings['autoload'] as $module) {
            $this->load($module);
        }
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function load($moduleName)
    {
        // get the path of the modules
        $modulesPath = $this->settings['modules_path'];

        // we want these items to be available to module.php
        $app = $this->app;
        $classLoader = $this->classLoader;
        $container = $this->app->getContainer();

        // include the required module.php path of that module
        $moduleClassPath = sprintf('%s/%s/module.php', $modulesPath, $moduleName);
        require $moduleClassPath;
    }
}

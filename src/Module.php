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

        $autoloadModules = $settings['autoload'];

        // 1) load initClassLoader() for each module
        // this will allow us to access other module's classes (e.g. Auth)
        foreach($autoloadModules as $moduleName) {
            // $this->initClassLoader($moduleName);
        }

        // 1) load initDependencies() for each module
        // this will allow us to access other module's dependencies (e.g. Auth)
        foreach($autoloadModules as $moduleName) {
            // $this->initDependencies($moduleName);
        }

        // 1) load initMiddleware() for each module
        // now that all dependencies have been init
        foreach($autoloadModules as $moduleName) {
            // $this->initMiddleware($moduleName);
        }

        // 2) load load() for each module so we can load classes
        // e.g. lastly, routes
        foreach($autoloadModules as $moduleName) {
            // $this->load($moduleName);
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

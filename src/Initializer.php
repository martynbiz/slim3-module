<?php
/**
 * Will load the module, initiating dependencies, etc first
 * @author Martyn Bissett <martynbissett@yahoo.co.uk>
 */

namespace MartynBiz\Slim3Module;

use Composer\Autoload\ClassLoader;

/**
 * This will load modules
 */
class Initializer
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

    /**
     * @var array
     */
    protected $moduleInstances = [];

    public function __construct($app, ClassLoader $classLoader, $settings=array())
    {
        $this->app = $app;
        $this->classLoader = $classLoader;
        $this->settings = $settings;

        // build an class map of [[module => moduleClassPath], ..]
        // $moduleClassMap = [];
        foreach ($this->settings['autoload'] as $moduleName) {

            // // e.g. "/path/to/modules/{module_name}/Module.php"
            // $moduleClassPath = realpath(sprintf('%s/%s/Module.php', $this->settings['modules_path'], $moduleName));
            // if (! $moduleClassPath) {
            //     throw new \Exception('Module class file could not be found');
            // }

            // // include the required module.php path of that module
            // require $moduleClassPath;

            // add to class map so we can easily access it later in this function
            $moduleClassName = sprintf('%s\Module', $moduleName);
            $this->moduleInstances[$moduleName] = new $moduleClassName();
        }
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function initModules()
    {
        $moduleInstances = $this->moduleInstances;
        $classLoader = $this->classLoader;
        $app = $this->app;
        $container = $app->getContainer();

        // next, load settings of all modules
        foreach ($moduleInstances as $moduleName => $module) {
            $allSettings = $container['settings']->all();
            if (!isset($allSettings['modules'][$moduleName]) or !is_array($allSettings['modules'][$moduleName])) {
                $allSettings['modules'][$moduleName] = [];
            }
            $allSettings['modules'] = array_merge_recursive($allSettings['modules'], $this->getModuleConfig());
            $container['settings']->__construct( $allSettings );
        }

        // $this->initClassLoader($classLoader);
        $this->initDependencies($container);
        $this->initMiddleware($app);
        $this->initRoutes($app);
    }

    // /**
    //  * Load the module. This will run for all modules, use for routes mainly
    //  * @param string $moduleName Module name
    //  */
    // public function initClassLoader()
    // {
    //     $moduleInstances = $this->moduleInstances;
    //     $classLoader = $this->classLoader;
    //
    //     foreach ($moduleInstances as $module) {
    //         $module->initClassLoader($classLoader);
    //     }
    // }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function getModuleConfig()
    {
        $moduleInstances = $this->moduleInstances;

        $allModules = [];
        foreach ($moduleInstances as $moduleName => $module) {
            $moduleSettings = $module->getModuleConfig();
            $allModules[$moduleName] = $module->getModuleConfig();
        }

        return $allModules;
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function initDependencies()
    {
        $moduleInstances = $this->moduleInstances;
        $app = $this->app;
        $container = $app->getContainer();

        // next, init dependencies of all modules now that we have settings, class maps etc
        foreach ($moduleInstances as $module) {
            $module->initDependencies($container);
        }
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function initMiddleware()
    {
        $moduleInstances = $this->moduleInstances;
        $app = $this->app;

        // next, init app middleware of all modules now that we have settings, class maps, dependencies etc
        foreach ($moduleInstances as $module) {
            $module->initMiddleware($app);
        }
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function initRoutes()
    {
        $moduleInstances = $this->moduleInstances;
        $app = $this->app;

        // lastly, routes
        foreach ($moduleInstances as $module) {
            $module->initRoutes($app);
        }
    }
}

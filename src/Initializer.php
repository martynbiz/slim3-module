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
     * @var array
     */
    protected $initializerSettings;

    /**
     * @var array
     */
    protected $moduleInstances = [];

    public function __construct($app, $modules=array())
    {
        $this->app = $app;

        // build an class map of [[module => moduleClassPath], ..]
        foreach ($modules as $module) {
            $moduleClassName = sprintf('%s\Module', $module);
            $this->moduleInstances[$module] = new $moduleClassName();
        }
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function initModules()
    {
        $moduleInstances = $this->moduleInstances;
        $app = $this->app;
        $container = $app->getContainer();

        // $this->initClassLoader($classLoader);
        $this->initModuleConfig();
        $this->initDependencies($container);
        $this->initMiddleware($app);
        $this->initRoutes($app);
    }

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
    public function initModuleConfig()
    {
        $app = $this->app;
        $container = $app->getContainer();

        $allSettings = $container['settings']->all();
        if (!isset($allSettings['modules']) or !is_array($allSettings['modules'])) {
            $allSettings['modules'] = [];
        }

        $allSettings['modules'] = array_merge_recursive($allSettings['modules'], $this->getModuleConfig());
        $container['settings']->__construct( $allSettings );
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

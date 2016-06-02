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

    public function __construct($app, ClassLoader $classLoader, $settings=array())
    {
        $this->app = $app;
        $this->classLoader = $classLoader;
        $this->settings = $settings;
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function initModules()
    {
        // build an class map of [[module => moduleClassPath], ..]
        $moduleClassMap = [];
        foreach ($this->settings['autoload'] as $moduleName) {

            // e.g. "/path/to/modules/{module_name}/Module.php"
            $moduleClassPath = realpath(sprintf('%s/%s/Module.php', $this->settings['modules_path'], $moduleName));
            if (! $moduleClassPath) {
                throw new \Exception('Module class file could not be found');
            }

            // include the required module.php path of that module
            require $moduleClassPath;

            // add to class map so we can easily access it later in this function
            $moduleClassName = sprintf('%s\Module', $moduleName);
            $moduleClassMap[$moduleName] = $moduleClassName;
        }

        // next, loop through each module and call methods in order

        $classLoader = $this->classLoader;
        $app = $this->app;
        $container = $app->getContainer();

        // first, class loader for all modules so that we can access classes between modules
        // e.g. other modules depend on Auth module, so we need to access those classes when
        // we initDependencies
        foreach ($moduleClassMap as $moduleClassName) {
            $moduleClassName::initClassLoader($classLoader);
        }

        // next, load settings of all modules
        foreach ($moduleClassMap as $moduleClassName) {
            $moduleSettings = $moduleClassName::getModuleConfig();
            $allSettings = $container['settings']->all();
            $container['settings']->__construct( array_merge_recursive($allSettings, $moduleSettings) );
        }

        // next, init dependencies of all modules now that we have settings, class maps etc
        foreach ($moduleClassMap as $moduleClassName) {
            $moduleClassName::initDependencies($container);
        }

        // next, init app middleware of all modules now that we have settings, class maps, dependencies etc
        foreach ($moduleClassMap as $moduleClassName) {
            $moduleClassName::initMiddleware($app);
        }

        // lastly, routes
        foreach ($moduleClassMap as $moduleClassName) {
            $moduleClassName::initRoutes($app);
        }
    }
}

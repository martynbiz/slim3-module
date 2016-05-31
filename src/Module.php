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
<<<<<<< Updated upstream
=======
     * @var ClassLoader
     */
    protected $classLoader;

    /**
>>>>>>> Stashed changes
     * @var array
     */
    protected $settings;

<<<<<<< Updated upstream
    public function __construct($app, $settings=array())
    {
        $this->app = $app;
        $this->settings = $settings;
=======
    public function __construct($app, ClassLoader $classLoader, $settings=array())
    {
        $this->app = $app;
        $this->classLoader = $classLoader;
        $this->settings = $settings;

        // load each module in $settings
        foreach($settings['autoload'] as $module) {
            $this->load($module);
        }
>>>>>>> Stashed changes
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function load($moduleName)
    {
        // get the path of the modules
<<<<<<< Updated upstream
        $modulePath = realpath($this->settings['modules_dir'] . '/' . $moduleName);
=======
        $modulesPath = $this->settings['modules_path'];
>>>>>>> Stashed changes

        // we want these items to be available to module.php
        $app = $this->app;
<<<<<<< Updated upstream
        require $modulePath . '/module.php';
=======
        $classLoader = $this->classLoader;
        $container = $this->app->getContainer();

        // include the required module.php path of that module
        $moduleClassPath = sprintf('%s/%s/module.php', $modulesPath, $moduleName);
        require $moduleClassPath;
>>>>>>> Stashed changes
    }
}

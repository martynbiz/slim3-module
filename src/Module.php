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

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Load the module. This will run for all modules, use for routes mainly
     * @param string $moduleName Module name
     */
    public function load($moduleName)
    {
        // get the path of the modules
        $modulePath = realpath(APPLICATION_PATH . '/modules/' . $moduleName);

        // include the required module.php path of that module
        $app = $this->app;
        require $modulePath . '/module.php';
    }

    // /**
    //  * This will return a closure that will only run when the module is required
    //  * when a route matches. It can be used to load module config
    //  * @param string $moduleName
    //  * @return \Closure
    //  */
    // public function __invoke($moduleName)
    // {
    //     $app = $this->app;
    //
    //     $callable = function ($request, $response, $next) use ($app, $moduleName) {
    //
    //         $container = $app->getContainer();
    //
    //         // anything within here will only run for the module that is
    //         // attached to the matching route (e.g. config/module.php)
    //
    //         // // merge config of this with app
    //         // $modulePath = realpath(APPLICATION_PATH . '/modules/' . $moduleName);
    //         // $moduleSettingsPath = $modulePath . '/config/module.php';
    //         // if (file_exists($moduleSettingsPath)) {
    //         //     $moduleSettings = require $moduleSettingsPath;
    //         // }
    //         // $container['settings']->__construct($moduleSettings);
    //
    //         $response = $next($request, $response);
    //
    //         return $response;
    //     };
    //
    //     return $callable;
    // }
}

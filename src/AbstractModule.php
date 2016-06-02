<?php
/**
 * this file should be included when loading the module
 * it will have access to $app which can be passed on to the
 * following files too
 * @author Martyn Bissett <martynbissett@yahoo.co.uk>
 */

namespace MartynBiz\Slim3Module;

use Composer\Autoload\ClassLoader;
use Slim\App;
use Slim\Container;

abstract class AbstractModule
{
    /**
     * Get config array for this module
     * @return array
     */
    public static function getModuleConfig()
    {
        return [];
    }

    /**
     * Set class maps for class loader to autoload classes for this module
     * @param ClassLoader $classLoader
     * @return void
     */
    public static function initClassLoader(ClassLoader $classLoader)
    {

    }

    /**
     * Set class maps for class loader to autoload classes for this module
     * @param Container $container
     * @return void
     */
    public static function initDependencies(Container $container)
    {

    }

    /**
     * Initiate app middleware, route middleware should go in load() with routes
     * @param App $app
     * @return void
     */
    public static function initMiddleware(App $app)
    {

    }

    /**
     * Load is run last, when config, dependencies, etc have been initiated
     * Routes ought to go here
     * @param App $app
     * @return void
     */
    public static function initRoutes(App $app)
    {

    }
}

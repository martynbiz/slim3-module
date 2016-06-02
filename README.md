# Slim v3 module #

## Introduction ##

Modules for Slim3

## Installation ##

Composer

```php
"require-dev": {
    "martynbiz/slim3-module": "dev-master"
}
```

## Getting started ##

This library expects a directory within the modules directory, and within that module a {module_name}/Module class:

```
modules/
├── Hello
│   └── Module.php
```

public/index.php

```php
$classLoader = require 'vendor/autoload.php';

$moduleInitializer = new \MartynBiz\Slim3Module\Module($classLoader, $app, [
    'autoload' => [ // <--- list of modules to autoload
        'Hello',
    ],
    'modules_path' => '/path/to/modules',
]);

```

/path/to/modules/Hello/Module.php

```php
namespace Hello;

use Slim\App;
use MartynBiz\Slim3Module\AbstractModule;

class Module extends AbstractModule
{
    public static function initRoutes(App $app)
    {
        $app->get('/hello/{name}', function (Request $request, Response $response) {
            $name = $request->getAttribute('name');
            $response->getBody()->write("Hello, $name");

            return $response;
        });
    }
}
```

## Advanced usage ##

It is possible for moodules to use libraries of other modules. To allow this, module initializer will load modules in the following order:

# Initiate class maps for all modules
# Import settings from all modules
# Initiate dependencies for all modules
# Initiate app middleware for all modules
# Lastly, initiate routes for all modules

To configure modules, simple override the methods of the AbstractModule class:

```php
namespace Hello;

use Composer\Autoload\ClassLoader;
use Slim\App;
use Slim\Container;
use MartynBiz\Slim3Module\AbstractModule;

class Module extends AbstractModule
{
    public static function getModuleConfig()
    {
        return [
            'logger' => [
                //...
            ],
        ];
    }

    public static function initClassLoader(ClassLoader $classLoader)
    {
        $classLoader->setPsr4("Hello\\", __DIR__ . "/src");
    }

    public static function initDependencies(Container $container)
    {
        $container['logger'] = function ($c) {
            $settings = $c->get('settings')['logger'];
            $logger = new \Monolog\Logger($settings['name']);
            $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
            $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], \Monolog\Logger::DEBUG));
            return $logger;
        };
        
        //...
    }
    
    public static function initMiddleware(App $app)
    {
        //...
    }

    public static function initRoutes(App $app)
    {
        $app->get('/hello/{name}', function (Request $request, Response $response) {
            $name = $request->getAttribute('name');
            $response->getBody()->write("Hello, $name");

            return $response;
        });
    }
}
```

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
$moduleInitializer = new \MartynBiz\Slim3Module\Initializer($app, [
    'autoload' => [ // <--- list of modules to autoload
        'Hello',
    ],
    'modules_path' => '/path/to/modules',
]);

$moduleInitializer->initModules();
```

composer.json

TODO add path to namespace e.g. App/Module

/path/to/modules/Hello/Module.php

```php
namespace Hello;

use Slim\App;
use MartynBiz\Slim3Module\AbstractModule;

class Module extends AbstractModule
{
    public function initRoutes(App $app)
    {
        $app->get('/hello/{name}', function ($request, $response) {
            $name = $request->getAttribute('name');
            $response->getBody()->write("Hello, $name");

            return $response;
        });
    }
}
```

## Advanced usage ##

It is possible for moodules to use libraries of other modules. To allow this, module initializer will load modules in the following order:

1. Initiate class maps for all modules
2. Import settings from all modules
3. Initiate dependencies for all modules
4. Initiate app middleware for all modules
5. Lastly, initiate routes for all modules

To configure modules, simple override the methods of the AbstractModule class:

```php
namespace Hello;

use Composer\Autoload\ClassLoader;
use Slim\App;
use Slim\Container;
use MartynBiz\Slim3Module\AbstractModule;

class Module extends AbstractModule
{
    public function getModuleConfig()
    {
        return [
            'logger' => [
                //...
            ],
        ];
    }

    public function initClassLoader(ClassLoader $classLoader)
    {
        $classLoader->setPsr4("Hello\\", __DIR__ . "/src");
    }

    public function initDependencies(Container $container)
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

    public function initMiddleware(App $app)
    {
        //...
    }

    public function initRoutes(App $app)
    {
        $app->get('/hello/{name}', function ($request, $response) {
            $name = $request->getAttribute('name');
            $response->getBody()->write("Hello, $name");

            return $response;
        });
    }
}
```

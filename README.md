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

## Simple Usage ##

This library expects a directory within the modules directory, and within that module a {module_name}/Module class:

```
modules/
├── Hello
│   └── Module.php
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

public/index.php

```php
$classLoader = require 'vendor/autoload.php';

$moduleInitializer = new \MartynBiz\Slim3Module\Module($classLoader, $app, [
    'autoload' => [ // <--- list of modules to autoload
        'Hello',
    ],
    'modules_path' => '/path/to/modules',
]);

moduleInitializer->initModules();
```

## Advanced initialization ##

### 

If you want to have library classes within modules, these can be autoloaded with
composer. Below is an example of library files autoloaded with PSR-4:

```
modules/
├── hello
│   └── library
│   │   └── Hello.php
│   └── module.php
```

From within the module.php file, the following can be used:

```php
// classLoader is made available to module.php during loading
$classLoader->setPsr4("Hello\\", __DIR__ . "/src");
```

Alternatively these can be loaded from the composer.json

```
"autoload": {
    "psr-4": {
        "Hello\\": "modules/hello/library/",
        .
        .
        .
```

### Module configuration ###

...

### README ###

Lastly, I recommend README file within each module to document how to install the
module within your app. This is not required though, but may come in handy months or
years down the line:

```
modules/
├── hello
│   └── module.php
│   └── README.md
```

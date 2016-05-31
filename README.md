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

This library expects a modules directory somewhere, and within that module directories:

```
modules/
├── hello
│   └── module.php
```

Each module file will contain code required for that module.

index.php

```php
$classLoader = require 'vendor/autoload.php';

$module = new \MartynBiz\Slim3Module\Module($classLoader, $app, [
    'autoload' => [ // <--- list of modules to autoload
        'hello',
    ],
    'modules_path' => '/path/to/modules',
]);
```

modules/application/module.php

```php
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});
```

## Advanced Usage ##

### Libraries within modules ###

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

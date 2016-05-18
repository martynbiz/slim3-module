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

Each module file will contain code required for that module. More advanced setups may
include sub-directories.

routes.php

```php
$module = new \MartynBiz\Slim3Module\Module($app, [
    'modules_dir' => APPLICATION_PATH . '/modules',
]);

$module->load('hello');
```

home/module.php

```php
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});
```

## Advanced Usage ##

...

## Modules within modules ##

...

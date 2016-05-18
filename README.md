# Slim v3 view #

## Introduction ##

A wrapper for Windwalker renderer (Blade, Twig, PHP etc) for use in Slim3 projects

See the Windwalker renderer here - https://github.com/ventoviro/windwalker

## Installation ##

Composer

```php
"require-dev": {
    "martynbiz/slim3-view": "dev-master"
}
```

## Usage ##

Below is an example usage within the slim3 skeleton app:

settings.php

```
$settings = [
    'settings' => [
        'renderer' => [
            'template_path' => '/path/to/views/',
            'cache_path' => '/path/to/cache/views',
        ],
        .
        .
        .
```

dependencies.php

```php
// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    // choose your weapon.. :) e.g. Blade, Twig, etc
    $renderer = new \Windwalker\Renderer\BladeRenderer(array(
        $settings['template_path'],
    ), array(
        'cache_path' => $settings['cache_path'],
    ));

    return new \MartynBiz\Slim3View\Renderer($renderer);
};
```

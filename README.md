# Choco Router
[![PHPUnit Tests](https://github.com/evgsavosin/choco-router/actions/workflows/phpunit.yml/badge.svg)](https://github.com/evgsavosin/choco-router/actions/workflows/phpunit.yml) [![License](https://img.shields.io/badge/license-MIT-green.svg?logo=github)](https://img.shields.io/badge/license-MIT-green.svg?logo=github) [![License](https://img.shields.io/badge/php-8.1-4f5b93.svg?logo=github)](https://img.shields.io/badge/php-8.1-4f5b93.svg?logo=github) 

Modern router for PHP based on regex expression with cache system. Caching has driver support: file system, APCum, Memcached. Defining routes is possible both using methods and attributes from PHP 8.0.

## Requirements
- PHP 8.1 or newer;
- APCu (optional);
- Memcached (optional).

## Install
Install via composer:
```php
composer require evgsavosin/choco-router
```

## Usage (deprecated)
Basic usage:
```php
<?php 
require 'vendor/autoload.php';

use ChocoRouter\Router;
use ChocoRouter\Exceptions\HttpException;

// Create router instance
$router = new Router();

// Add route with GET method
$router->get('/foo', 'foo');
$router->get('/foo/bar', function () {
  // ...
});

try {
    $result = $router->dispatch(
      $_SERVER['REQUEST_METHOD'], 
      $_SERVER['REQUEST_URI']
    );
    
    // Call class method or function
    call_user_func($result['handler'], $result['args']);
} catch (HttpException $e) {
    if ($e->getCode() == HttpException::NOT_FOUND) {
        // Handle not found page
    }
}

// Declare function
function foo(array $args) {
  // ...
}
```


Available methods:
```php 
$router->group('/foo', function () use ($router) {
    $router->get('/bar', 'foo');
    $router->post('/bar', 'foo');
    $router->delete('/bar', 'foo');
    $router->put('/bar', 'foo');
    $router->map(['POST', 'GET'], '/bar/baz', 'foo');
});
```

Parameters:
```php
$router->get('/foo/{bar}/{baz?}', 'foo', [
  'bar' => '[a-zA-Z]',
  'baz' => '[0-9]'
]);
```

> A question mark means the parameter is optional

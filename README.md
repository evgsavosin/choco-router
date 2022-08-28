# Simple Routing
Simple routing on regex expression.

## Requirements
- PHP 7.4 or newer

## Install
Install via composer:
```php
composer require evgsavosin/simple-routing
```

## Usage
Basic usage:
```php
<?php 
require 'vendor/autoload.php';

use SimpleRouting\Router;
use SimpleRouting\Exception\HttpException;

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

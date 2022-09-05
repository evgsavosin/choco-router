# Choco Router
[![PHPUnit Tests](https://github.com/evgsavosin/choco-router/actions/workflows/phpunit.yml/badge.svg)](https://github.com/evgsavosin/choco-router/actions/workflows/phpunit.yml) 
[![Stable](https://poser.pugx.org/evgsavosin/choco-router/v/stable.svg)](https://packagist.org/packages/evgsavosin/choco-router)
[![PHP](https://img.shields.io/badge/php-8.1-4f5b93.svg?logo=github)](https://img.shields.io/badge/php-8.1-4f5b93.svg?logo=github) 
[![License](https://poser.pugx.org/evgsavosin/choco-router/license.svg)](https://packagist.org/packages/evgsavosin/choco-router)

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

## Usage
### Basic usage
To use it is necessary to define the call of classes using for example PSR-11 implementation.
```php
<?php 

declare(strict_types=1);

require 'vendor/autoload.php';

use ChocoRouter\SimpleRouter;
use ChocoRouter\HttpMethod;

$router = new SimpleRouter();

$router->addRoute(HttpMethod::GET, '/foo', fn (): string => 'Foo!' );
$router->addRoute(
    HttpMethod::POST, 
    '/foo/{bar}', 
    fn (mixed $value): string => "Foo bar and {$value}!",
    ['bar' => '[0-9]+']
);

try {
    $router->resolve(
        $_SERVER['REQUEST_METHOD'], 
        $_SERVER['REQUEST_URI']
    )->callableResolve(function (mixed $handler, array $arguments): mixed {
        if (is_string($handler)) {
            [$controllerName, $methodName] = explode('@', $handler);

            // PSR-11 implementation for classes: controllers, actions and etc...
        } elseif (is_callable($handler)) {
            $handler(...$arguments);
        }
    }); 
} catch (HttpException $e) {
    if ($e->getCode() === HttpException::NOT_FOUND) {
        // Handle 404...
    } else if ($e->getCode() === HttpException::BAD_REQUEST) {
        // Handle 400...
    }
}
```

### Route definition
The route can be defined with method: `addRoute(HttpMethod $httpMethod, string $uri, mixed $handler, array $parameters = []): void`. Parameters can be passed `{bar}` or `{bar?}` with regular expressions `['bar' => '[0-9]+']`.
Real example:
```php
$router->addRoute(HttpMethod::GET, '/foo/{bar?}', 'foo-bar', ['bar' => '[0-9]+']);
```
> A question mark means the parameter is optional.

The route group is defined using `addGroup(string $prefix, callable $callback): void` method. Real example: 
```php
$router->addGroup('/gorge', function (RouteCollection $r): void {
    $router->addRoute(HttpMethod::GET, '/foo/{bar?}', 'foo-bar', ['bar' => '[0-9]+']);
});
```

### HTTP Methods

Full list of methods:

```php 
HttpMethod::CONNECT
HttpMethod::HEAD
HttpMethod::GET
HttpMethod::POST
HttpMethod::PUT
HttpMethod::DELETE
HttpMethod::OPTIONS
```

### Configuration

You can set the configuration when initializing a simple router:
```php
$router = new SimpleRouter([
    'cacheDisable' => false,
    'cacheDriver' => FileDriver::class,
    'cacheOptions' => [] 

    /*
        For memcached driver, there passed array of servers. 
        For file driver, there passed path to cache directory.
    */
]);
```

### Attributes

The router supports attributes from PHP 8.0. Example:

```php 
use App\Action\FooAction;

$router = new SimpleRouter();
$router->load([FooAction::class]);
$router->resolve(/*...*/)->callableResolve(/*...*/);
```

### Cache

Router has support cache system with defined drivers:
- `ChocoRouter\Cache\Drivers\FileDriver::class`;
- `ChocoRouter\Cache\Drivers\ApcuDriver::class`;
- `ChocoRouter\Cache\Drivers\MemcachedDriver::class`.

For use cache move definition routes to cache callback:
```php 
$router = new SimpleRouter([
    'cacheDriver' => FileDriver::class
]);

$router->cache(static function (RouteCollection $r): void {
    $r->addRoute(HttpMethod::GET, '/foo/{bar}', App\Actions\FooAction::class, ['bar' => '[0-9]+']);
});

$router->resolve(/*...*/)->callableResolve(/*...*/);
```

## Contributing

The author has not yet had time to write instructions, but any pull request or issue will be glad.

## License

Choco Router has MIT License.

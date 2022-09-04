<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Controllers\{FooController, BazAction};
use ChocoRouter\Attribute\AttributeLoader;
use ChocoRouter\Resolver\ResolverResult;
use ChocoRouter\Exceptions\HttpException;
use ChocoRouter\{HttpMethod, RouteCollection, Router};

final class RouterTest extends TestCase
{
    public function testRouteSimpleHandling(): void
    {
        $collection = new RouteCollection();
        $collection->addRoute(HttpMethod::GET, '/foo/{bar}', 'foo-bar', ['bar' => '[0-9]+']);
        $router = new Router($collection);
        $result = $router->resolve('GET', '/foo/1');

        $this->assertInstanceOf(ResolverResult::class, $result);
    }

    public function testRouteAttributeHandling(): void
    {
        $collection = new RouteCollection();
        $collection->addRoute(HttpMethod::GET, '/foo/{bar}', 'foo-bar', ['bar' => '[0-9]+']);
        
        $loader = new AttributeLoader($collection);
        $loader->load([FooController::class, BazAction::class]);

        $router = new Router($collection);
        $result = $router->resolve('GET', '/foo/1');

        $this->assertInstanceOf(ResolverResult::class, $result);
    }

    public function testRouteNotFound(): void
    {
        $collection = new RouteCollection();

        try {
            $router = new Router($collection);
            $router->resolve('GET', '/foo');
        } catch (HttpException $e) {
            $this->assertInstanceOf(HttpException::class, $e);
            $this->assertSame($e->getCode(), HttpException::NOT_FOUND);
        }
    }
}
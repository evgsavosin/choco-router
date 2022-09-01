<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Controllers\{FooController, BazAction};
use SimpleRouting\Attribute\AttributeLoader;
use SimpleRouting\Dispatcher\DispatcherResult;
use SimpleRouting\Exceptions\HttpException;
use SimpleRouting\{RouteCollection, Router};

final class RouterTest extends TestCase
{
    public function testRouteSimpleHandling(): void
    {
        $collection = new RouteCollection();
        $collection->addRoute('GET', '/foo/{bar}', 'foo-bar', ['bar' => '[0-9]+']);
        $router = new Router($collection);
        $result = $router->handle('GET', '/foo/1');

        $this->assertInstanceOf(DispatcherResult::class, $result);
    }

    public function testRouteAttributeHandling(): void
    {
        $collection = new RouteCollection();
        $collection->addRoute('GET', '/foo/{bar}', 'foo-bar', ['bar' => '[0-9]+']);
        
        $loader = new AttributeLoader($collection);
        $loader->load([FooController::class, BazAction::class]);

        $router = new Router($collection);
        $result = $router->handle('GET', '/foo/1');

        $this->assertInstanceOf(DispatcherResult::class, $result);
    }

    public function testRouteNotFound(): void
    {
        $collection = new RouteCollection();

        try {
            $router = new Router($collection);
            $router->handle('GET', '/foo');
        } catch (HttpException $e) {
            $this->assertInstanceOf(HttpException::class, $e);
            $this->assertSame($e->getCode(), HttpException::NOT_FOUND);
        }
    }
}
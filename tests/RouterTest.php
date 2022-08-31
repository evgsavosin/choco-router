<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SimpleRouting\Dispatcher\DispatcherResult;
use SimpleRouting\Exceptions\HttpException;
use SimpleRouting\Router;

final class RouterTest extends TestCase
{
    public function testRouteDispatching(): void
    {
        $router = new Router();

        $router->get('/foo/{bar}/', 'foo-bar', ['bar' => '[0-9]+']);
        $result = $router->dispatch('GET', '/foo/1/');

        $this->assertInstanceOf(DispatcherResult::class, $result);
    }

    public function testRouteNotFound(): void
    {
        $router = new Router();

        try {
            $router->dispatch('GET', '/foo');
        } catch (HttpException $e) {
            $this->assertInstanceOf(HttpException::class, $e);
            $this->assertSame($e->getCode(), HttpException::NOT_FOUND);
        }
    }
}
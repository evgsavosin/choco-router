<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SimpleRouting\RouteCollection;
use SimpleRouting\RouteDispatcher;

final class RouteDispatcherTest extends TestCase
{
    public function testDispatchRouting()
    {
        $routeCollection = new RouteCollection;

        $routeCollection->addRoute('GET', '/foo/{test}/', 'foo', [
            'abs' => '[0-9]'
        ]);
        $routeCollection->addRoute('GET', '/foo/bar', 'foo-bar');
        $routeCollection->addRoute('GET', '/foo/bar/{id}/{action}/{testt?}', 'foo-bar-id', [
            'id' => '[0-9]',
            'action' => '[a-zA-Z]'
        ]);

        $routeList = $routeCollection->getRoutes();
        $routeDispatcher = new RouteDispatcher($routeList);

        $result = $routeDispatcher->handle('GET', '/foo/tw5325%31/');

        return $this->assertSame($result, []);
    }
}
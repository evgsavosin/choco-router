<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use ChocoRouter\RouteCollection;
use ChocoRouter\HttpMethod;

final class RouteCollectionTest extends TestCase
{
    public function testRouteCreation(): void
    {
        $routeCollection = new RouteCollection();

        $routeCollection->addRoute(HttpMethod::GET, '/foo', 'foo');
        $routeCollection->addRoute(HttpMethod::POST, '/foo/bar', 'foo-bar');
        $routeCollection->addRoute(HttpMethod::DELETE, '/foo/bar/baz', 'foo-bar-baz');
        $routeCollection->addRoute(HttpMethod::PUT, '/foo/bar/baz/quux', 'foo-bar-baz-quux');

        $routeCollectionList = $routeCollection->getRoutes();
        $currentRoutes = [];

        foreach ($routeCollectionList as $routeItem) {
            $currentRoutes[] = [
                $routeItem->getHttpMethod(), 
                $routeItem->getExpression()->getPattern()
            ];
        }

        $this->assertIsArray($currentRoutes);

        $this->assertSame($currentRoutes, [
            [HttpMethod::GET, '/foo'],
            [HttpMethod::POST, '/foo/bar'],
            [HttpMethod::DELETE, '/foo/bar/baz'],
            [HttpMethod::PUT, '/foo/bar/baz/quux']
        ]);
    }
}
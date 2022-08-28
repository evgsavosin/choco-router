<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SimpleRouting\RouteCollection;

final class RouteCollectionTest extends TestCase
{
    public function testRouteCreation(): void
    {
        $routeCollection = new RouteCollection();

        $routeCollection->addRoute('GET', '/foo', 'foo');
        $routeCollection->addRoute('POST', '/foo/bar', 'foo-bar');
        $routeCollection->addRoute('DELETE', '/foo/bar/baz', 'foo-bar-baz');
        $routeCollection->addRoute('PUT', '/foo/bar/baz/quux', 'foo-bar-baz-quux');

        $routeCollectionList = $routeCollection->getRoutes();
        $currentRoutes = [];

        foreach ($routeCollectionList as $routeItem) {
            $currentRoutes[] = [
                $routeItem->getHttpMethod(), 
                $routeItem->getUri()
            ];
        }

        $this->assertIsArray($currentRoutes);

        $this->assertSame($currentRoutes, [
            ['GET', '/foo'],
            ['POST', '/foo/bar'],
            ['DELETE', '/foo/bar/baz'],
            ['PUT', '/foo/bar/baz/quux']
        ]);
    }
}
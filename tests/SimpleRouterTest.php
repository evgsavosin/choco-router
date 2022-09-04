<?php 

declare(strict_types=1);

namespace Tests;

use ChocoRouter\Cache\Drivers\FileDriver;
use PHPUnit\Framework\TestCase;
use ChocoRouter\Dispatcher\DispatcherResult;
use ChocoRouter\HttpMethod;
use ChocoRouter\RouteCollection;
use ChocoRouter\SimpleRouter;

final class SimpleRouterTest extends TestCase
{
    public function testSimpleRouterHandling(): void
    {
        $router = new SimpleRouter();
        $router->addRoute(HttpMethod::GET, '/foo/{bar}', 'foo-bar', ['bar' => '[0-9]+']);
        $result = $router->handle('GET', '/foo/1');

        $this->assertInstanceOf(DispatcherResult::class, $result);
    }

    public function testSimpleRouterCacheViaFileDriver(): void
    {
        $router = new SimpleRouter([
            'cacheDisable' => false,
            'cacheDriver' => FileDriver::class
        ]);

        $router->cache(static function (RouteCollection $r) {
            $r->addRoute(HttpMethod::GET, '/foo/{bar}', 'foo-bar', ['bar' => '[0-9]+']);
        });

        $result = $router->handle('GET', '/foo/1');
        $this->assertInstanceOf(DispatcherResult::class, $result);
    }
}
<?php 

declare(strict_types=1);

namespace Tests;

use ChocoRouter\Cache\Drivers\FileDriver;
use PHPUnit\Framework\TestCase;
use ChocoRouter\Resolver\ResolverResult;
use ChocoRouter\HttpMethod;
use ChocoRouter\RouteCollection;
use ChocoRouter\SimpleRouter;

final class SimpleRouterTest extends TestCase
{
    public function testOneParameterHandling(): void
    {
        $router = new SimpleRouter();
        $router->addRoute(HttpMethod::GET, '/foo/{bar}', 'foo-bar', ['bar' => '[0-9]+']);
        $result = $router->resolve('GET', '/foo/1');

        $this->assertInstanceOf(ResolverResult::class, $result);
    }

    public function testTwoParametersHandling(): void
    {
        $router = new SimpleRouter();
        $router->addRoute(HttpMethod::GET, '/foo/{bar}/{quxx?}', 'foo-bar', [
            'quxx' => '[a-zA-Z]+',
            'bar' => '[0-9]+'
        ]);

        $result = $router->resolve('GET', '/foo/1/');

        $this->assertInstanceOf(ResolverResult::class, $result);
    }

    public function testCacheViaFileDriver(): void
    {
        $router = new SimpleRouter([
            'cacheDisable' => false,
            'cacheDriver' => FileDriver::class
        ]);

        $router->cache(static function (RouteCollection $r) {
            $r->addRoute(HttpMethod::GET, '/foo/{bar}', 'foo-bar', ['bar' => '[0-9]+']);
        });

        $result = $router->resolve('GET', '/foo/1');
        $this->assertInstanceOf(ResolverResult::class, $result);
    }
}
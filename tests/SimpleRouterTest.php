<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use ChocoRouter\Dispatcher\DispatcherResult;
use ChocoRouter\SimpleRouter;

final class SimpleRouterTest extends TestCase
{
    public function testSimpleRouterHandling(): void
    {
        $router = new SimpleRouter();
        $router->get('/foo/{bar}', 'foo-bar', ['bar' => '[0-9]+']);
        $result = $router->handle('GET', '/foo/1');

        $this->assertInstanceOf(DispatcherResult::class, $result);
    }
}
<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Controllers\FooController;
use SimpleRouting\Route;
use SimpleRouting\Attribute\AttributeLoader;
use SimpleRouting\Router;

use function PHPUnit\Framework\assertInstanceOf;

final class AttributeLoaderTest extends TestCase
{
    public function testRouteDispatching(): void
    {
        $router = new Router();
        $loader = new AttributeLoader($router);
        
        $loader->load([
            FooController::class
        ]);

        assertInstanceOf(
            Route::class, 
            $router->getCollection()->getRoutes()[0]
        );
    }
}
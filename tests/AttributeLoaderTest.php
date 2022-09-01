<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Controllers\{FooController, BazAction};
use ChocoRouter\Route;
use ChocoRouter\Attribute\AttributeLoader;
use ChocoRouter\RouteCollection;

use function PHPUnit\Framework\assertInstanceOf;

final class AttributeLoaderTest extends TestCase
{
    public function testRouteDispatching(): void
    {
        $collection = new RouteCollection();
        $loader = new AttributeLoader($collection);
        
        $loader->load([
            FooController::class,
            BazAction::class
        ]);

        foreach ($collection->getRoutes() as $route) {
            assertInstanceOf(Route::class, $route);
        }
    }
}
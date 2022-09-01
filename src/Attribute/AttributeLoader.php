<?php 

declare(strict_types=1);

namespace ChocoRouter\Attribute;

use ChocoRouter\Attribute\Route;
use ChocoRouter\RouteCollection;
use ReflectionClass;

/**
 * Attribute loader for MVC (controllers, actions and etc.)
 * 
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class AttributeLoader implements AttributeLoaderInterface
{
    public function __construct(
        protected RouteCollection $collection
    ) {}

    public function load(array $classes): void
    {
        foreach ($classes as $class) {
            $reflection = new ReflectionClass($class);
            $this->eachAttributes(
                $reflection->getAttributes(Route::class), 
                $reflection->getName()
            );

            $methods = $reflection->getMethods();

            foreach ($methods as $method) {
                $this->eachAttributes(
                    $method->getAttributes(Route::class), 
                    "{$reflection->getName()}@{$method->getName()}"
                );
            }
        }
    }

    private function eachAttributes(array $attributes, mixed $handler): void
    {
        foreach ($attributes as $attribute) {
            /** @var Route $instance */
            $instance = $attribute->newInstance();
            
            $this->collection->addRoute(
                $instance->getHttpMethod(),
                $instance->getUri(),
                $handler,
                $instance->getParameters()
            );
        }
    }
}
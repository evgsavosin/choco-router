<?php 

declare(strict_types=1);

namespace SimpleRouting\Attribute;

use SimpleRouting\Attribute\Route;
use SimpleRouting\Router;
use ReflectionClass;

class AttributeLoader implements AttributeLoaderInterface
{
    public array $controllers;

    public function __construct(
        protected Router $router
    ) {}

    public function load(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $reflection = new ReflectionClass($controller);
            $methods = $reflection->getMethods();

            foreach ($methods as $method) {
                $attributes = $method->getAttributes(Route::class);
                
                foreach ($attributes as $attribute) {
                    /** @var Route $instance */
                    $instance = $attribute->newInstance();
                    
                    $this->router->getCollection()->addRoute(
                        $instance->getHttpMethod(),
                        $instance->getUri(),
                        "{$reflection->getNamespaceName()}@{$method->getName()}",
                        $instance->getParameters()
                    );
                }
            }
        }
    }
}
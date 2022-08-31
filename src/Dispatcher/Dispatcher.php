<?php 

declare(strict_types=1);

namespace SimpleRouting\Dispatcher;

use SimpleRouting\RouteCollection;

class Dispatcher implements DispatcherInterface
{
    public function __construct(
        protected RouteCollection $collection
    ){}

    public function handle(string $httpMethod, string $uri): ?DispatcherResult
    {
        $routes = $this->collection->getRoutes();

        foreach ($routes as $route) {
            if ($route->getHttpMethod() !== $httpMethod) {
                continue;
            }

            $expression = $route->getExpression();

            if (
                (!$route->hasParameters() && $expression->getValue() == $uri)
                || ($route->hasParameters() && preg_match($expression->getPattern(), $uri, $matches))
            ) {
                return new DispatcherResult(
                    $route, 
                    $uri,
                    $this->matchParameters($route->getParameters(), $matches)
                );
            }
        }

        return null;
    }

    public function matchParameters(array $parameters, array $values): array
    {
        $i = 1;
        $parameterValues = [];

        foreach ($parameters as $key => $pattern) {
            if (isset($values[$i])) {
                $parameterValues[$key] = $values[$i];
            }

            $i++;
        }

        return $parameterValues;
    }
}
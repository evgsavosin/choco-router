<?php 

declare(strict_types=1);

namespace ChocoRouter\Resolver;

use ChocoRouter\{HttpMethod, RouteCollection};

/**
 * Resolve request to router and match route with parameters
 * 
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class Resolver implements ResolverInterface
{
    public function __construct(
        protected RouteCollection $collection
    ){}

    public function resolve(string $httpMethod, string $uri): ?ResolverResult
    {
        $routes = $this->collection->getRoutes();

        foreach ($routes as $route) {
            if ($route->getHttpMethod() !== HttpMethod::tryFrom($httpMethod)) {
                continue;
            }

            $expression = $route->getExpression();

            if (
                (!$route->hasParameters() && $expression->getValue() == $uri)
                || ($route->hasParameters() && preg_match($expression->getPattern(), $uri, $matches))
            ) {
                return new ResolverResult(
                    $route, 
                    $uri,
                    $this->matchParameters(
                        $route->getParameters(), 
                        $matches ?? []
                    )
                );
            }
        }

        return null;
    }

    public function matchParameters(array $parameters, array $values = []): ?array
    {
        if ($parameters === []) {
            return [];
        }

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
<?php 

declare(strict_types=1);

namespace SimpleRouting;

class RouteDispatcher
{
    protected array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function handle(string $httpMethod, string $uri): ?array
    {
        $routes = $this->routes;
        $handler = '';
        $args = [];

        foreach ($routes as $route) {
            if ($route->getHttpMethod() == $httpMethod) {
                $routeRegex = $route->getRegex();
                $routeUri = $route->getUri();
                $regexExpressionExists = !empty($routeRegex);

                if ((!$regexExpressionExists && $routeUri == $uri) 
                || ($regexExpressionExists && preg_match($routeUri, $uri, $matches))) {
                    $handler = $route->getHandler();
                    $args = [];

                    if ($regexExpressionExists) {
                        $args = $this->processArgs($matches, $routeRegex);
                    }
                    
                    break;
                }
            }
        }

        if ($handler === '') {
            return null;
        }

        return [
            'handler' => $handler,
            'args' => $args
        ];
    }

    private function processArgs(?array $matches, ?array $regex): array
    {
        $i = 1;
        $args = [];

        foreach ($regex as $key => $pattern) {
            if (isset($matches[$i])) {
                $args[$key] = $matches[$i];
            }

            $i++;
        }

        return $args;
    }
}

<?php 

declare(strict_types=1);

namespace SimpleRouting;

class RouteCollection
{
    protected array $routes = [];
    protected string $groupPrefix;
    protected RouteParser $routeParser;

    public function __construct(?RouteParser $routeParser = null)
    {
        $this->groupPrefix = '';
        $this->routeParser = $routeParser ?? new RouteParser();
    }
    
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function setGroupPrefix(string $prefix): void
    {
        $this->groupPrefix = $prefix;
    }

    public function getGroupPrefix(): string
    {
        return $this->groupPrefix;
    }

    public function addGroup(string $prefix, callable $callback): void
    {
        $oldGroupPrefix = $this->getGroupPrefix();
    
        $this->setGroupPrefix($oldGroupPrefix . $prefix);
        $callback($this);
        $this->setGroupPrefix($oldGroupPrefix);
    }

    public function addRoute(string $httpMethod, string $uri, $handler, ?array $regex = null): void
    {
        $uri = $this->getGroupPrefix() . $uri;
        $uri = $this->routeParser->make($uri, $regex);

        $this->routes[] = new Route(
            $httpMethod, 
            $uri, 
            $handler,
            $regex
        );
    }
}
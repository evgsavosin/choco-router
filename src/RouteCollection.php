<?php 

declare(strict_types=1);

namespace SimpleRouting;

use SimpleRouting\Matcher\Matcher;
use SimpleRouting\Matcher\MatcherInterface;

class RouteCollection
{
    protected array $routes = [];

    public function __construct(
        protected ?MatcherInterface $matcher = null,
        protected string $groupPrefix = ''
    ) {
        $this->matcher = $matcher ?? new Matcher();
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

    public function addRoute(string $httpMethod, string $uri, $handler, array $regex = []): void
    {
        $uri = $this->getGroupPrefix() . $uri;

        $this->routes[] = new Route(
            $httpMethod, 
            $this->matcher->match($uri, $regex), 
            $handler,
            $regex
        );
    }
}
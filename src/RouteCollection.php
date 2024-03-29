<?php 

declare(strict_types=1);

namespace ChocoRouter;

use ChocoRouter\Matcher\Matcher;
use ChocoRouter\Matcher\MatcherInterface;

/**
 * @since 1.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class RouteCollection
{
    /** @var Route[] */
    protected array $routes = [];
    
    protected ?MatcherInterface $matcher;

    protected string $groupPrefix = '';

    public function __construct() 
    {
        $this->matcher = new Matcher();
    }

    /**
     * @param Route[] $routes
     */
    public function fromArray(array $routes): void
    {
        $this->routes = $routes;
    }
    
    /**
     * @return Route[]
     */
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
        $oldPrefix = $this->getGroupPrefix();
    
        $this->setGroupPrefix($oldPrefix . $prefix);
        $callback($this);
        $this->setGroupPrefix($oldPrefix);
    }

    public function addRoute(HttpMethod $httpMethod, string $uri, mixed $handler, array $parameters = []): void
    {
        $uri = $this->getGroupPrefix() . $uri;

        $this->routes[] = new Route(
            $httpMethod, 
            $this->matcher->match($uri, $parameters), 
            $handler,
            $parameters
        );
    }
}
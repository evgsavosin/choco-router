<?php declare(strict_types=1);

namespace SimpleRouting;

class RouteCollection
{
    /**
     * @var array $route
     */
    protected array $routes = [];

    /**
     * @var string $groupPrefix
     */
    protected string $groupPrefix;

    /**
     * @var RouteParser $routeParser
     */
    protected RouteParser $routeParser;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct(?RouteParser $routeParser = null)
    {
        $this->groupPrefix = '';
        $this->routeParser = $routeParser ?? new RouteParser;
    }
    
    /**
     * Get route collection
     * 
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Set group prefix
     * 
     * @param string $prefix
     * @return void
     */
    public function setGroupPrefix(string $prefix): void
    {
        $this->groupPrefix = $prefix;
    }

    /**
     * Get group prefix
     * 
     * @return string
     */
    public function getGroupPrefix(): string
    {
        return $this->groupPrefix;
    }

    /**
     * Add group prefix
     * 
     * @param string $prefix 
     * @param callable $callback
     * @return void
     */
    public function addGroup(string $prefix, callable $callback): void
    {
        $oldGroupPrefix = $this->getGroupPrefix();

        // Change prefix
        $this->setGroupPrefix($oldGroupPrefix . $prefix);

        // Call function
        $callback($this);

        // Return old prefix
        $this->setGroupPrefix($oldGroupPrefix);
    }

    /**
     * Adding route to collection
     * 
     * @param string $httpMethod
     * @param string $uri
     * @param string|callable $handler
     * @param array|null $regex
     * 
     * @return void
     */
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
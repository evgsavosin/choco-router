<?php declare(strict_types=1);

namespace SimpleRouting;

use SimpleRouting\Exception\HttpException;

final class Router 
{
    /**
     * @var RouteCollection $routeCollection
     */
    protected RouteCollection $routeCollection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $routeParser = new RouteParser;
        $this->routeCollection = new RouteCollection($routeParser);
    }

    /**
     * Short function of adding group
     * 
     * @param string $prefix 
     * @param callable $callback
     * 
     * @return void
     */
    public function group(string $prefix, callable $callback): void
    {
        $this->routeCollection->addGroup($prefix, $callback);
    }

    /**
     * Adding route with multiple HTTP methods to collection
     * 
     * @param array $httpMethods
     * @param string $uri
     * @param string|callable $handler
     * @param array|null $regex
     * 
     * @return void
     */
    public function map(array $httpMethods, string $uri, $handler, ?array $regex = null): void
    {
        foreach ($httpMethods as $method) {
            $this->routeCollection->addRoute($method, $uri, $handler, $regex);
        }
    }

    /**
     * Adding route as GET to collection
     * 
     * @param array $httpMethods
     * @param string $uri
     * @param string|callable $handler
     * @param array|null $regex
     * 
     * @return void
     */
    public function get(string $uri, $handler, ?array $regex = null): void
    {
        $this->routeCollection->addRoute('GET', $uri, $handler, $regex);
    }

    /**
     * Adding route as POST to collection
     * 
     * @param array $httpMethods
     * @param string $uri
     * @param string|callable $handler
     * @param array|null $regex
     * 
     * @return void
     */
    public function post(string $uri, $handler, ?array $regex = null): void
    {
        $this->routeCollection->addRoute('POST', $uri, $handler, $regex);
    }

    /**
     * Adding route as DELETE to collection
     *
     * @param array $httpMethods
     * @param string $uri
     * @param string|callable $handler
     * @param array|null $regex
     * 
     * @return void
     */
    public function delete(string $uri, $handler, ?array $regex = null): void
    {
        $this->routeCollection->addRoute('DELETE', $uri, $handler, $regex);
    }

    /**
     * Adding route as PUT to collection
     * 
     * @param array $httpMethods
     * @param string $uri
     * @param string|callable $handler
     * @param array|null $regex
     * 
     * @return void
     */
    public function put(string $uri, $handler, ?array $regex = null): void
    {
        $this->routeCollection->addRoute('PUT', $uri, $handler, $regex);
    }

    /**
     * @param string $httpMethod
     * @param string $uri
     * 
     * @throws HttpException
     * 
     * @return array
     */
    public function dispatch(?string $httpMethod = null, ?string $uri = null): array
    {
        $httpMethod = $httpMethod ?? $_SERVER['REQUEST_METHOD'];
        $uri = $uri ?? $_SERVER['REQUEST_URI'];

        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        $routeDispatcher = new RouteDispatcher(
            $this->routeCollection->getRoutes()
        );

        if (($result = $routeDispatcher->handle($httpMethod, $uri)) === null) {
            throw new HttpException('Route not found', HttpException::NOT_FOUND);
        }

        return $result;
    }
}
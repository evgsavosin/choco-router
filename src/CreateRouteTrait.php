<?php 

declare(strict_types=1);

namespace SimpleRouting;

/** @property RouteCollection $collection */
trait CreateRouteTrait
{
    public function group(string $prefix, callable $callback): void
    {
        $this->collection->addGroup($prefix, $callback);
    }

    /**
     * Adding route with multiple HTTP methods to collection
     */
    public function map(array $httpMethods, string $uri, mixed $handler, array $parameters = []): void
    {
        foreach ($httpMethods as $method) {
            $this->collection->addRoute($method, $uri, $handler, $parameters);
        }
    }

    /**
     * Adding route as GET to collection
     */
    public function get(string $uri, mixed $handler, array $parameters = []): void
    {
        $this->collection->addRoute('GET', $uri, $handler, $parameters);
    }

    /**
     * Adding route as POST to collection
     */
    public function post(string $uri, mixed $handler, array $parameters = []): void
    {
        $this->collection->addRoute('POST', $uri, $handler, $parameters);
    }

    /**
     * Adding route as DELETE to collection
     */
    public function delete(string $uri, mixed $handler, array $parameters = []): void
    {
        $this->collection->addRoute('DELETE', $uri, $handler, $parameters);
    }

    /**
     * Adding route as PUT to collection
     */
    public function put(string $uri, mixed $handler, array $parameters = []): void
    {
        $this->collection->addRoute('PUT', $uri, $handler, $parameters);
    }
}
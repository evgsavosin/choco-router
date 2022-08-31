<?php 

declare(strict_types=1);

namespace SimpleRouting;

use SimpleRouting\Dispatcher\{Dispatcher, DispatcherResult};
use SimpleRouting\Exceptions\HttpException;

final class Router 
{
    protected RouteCollection $collection;

    protected Dispatcher $dispatcher;

    public function __construct()
    {
        $this->collection = new RouteCollection();
        $this->dispatcher = new Dispatcher($this->collection);
    }

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

    /**
     * @throws HttpException
     */
    public function dispatch(?string $httpMethod = null, ?string $uri = null): DispatcherResult
    {
        if ($httpMethod === null) {
            throw new HttpException('Bad request', HttpException::BAD_REQUEST);
        }

        if ($uri === null) {
            throw new HttpException('Not found', HttpException::NOT_FOUND);
        }

        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        if (($result = $this->dispatcher->handle($httpMethod, $uri)) === null) {
            throw new HttpException('Route not found', HttpException::NOT_FOUND);
        }

        return $result;
    }
}
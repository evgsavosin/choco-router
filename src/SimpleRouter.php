<?php 

declare(strict_types=1);

namespace ChocoRouter;

use ChocoRouter\Dispatcher\DispatcherResult;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
final class SimpleRouter 
{
    protected Router $router;

    public function __construct()
    {
        $this->router = new Router(
            new RouteCollection()
        );
    }

    public function getCollection(): RouteCollection
    {
        return $this->router->getCollection();
    }

    public function group(string $prefix, callable $callback): void
    {
        $this->router->getCollection()->addGroup($prefix, $callback);
    }

    /**
     * Adding route with multiple HTTP methods to collection
     */
    public function map(array $httpMethods, string $uri, mixed $handler, array $parameters = []): void
    {
        foreach ($httpMethods as $method) {
            $this->router->getCollection()->addRoute($method, $uri, $handler, $parameters);
        }
    }

    /**
     * Adding route as GET to collection
     */
    public function get(string $uri, mixed $handler, array $parameters = []): void
    {
        $this->router->getCollection()->addRoute('GET', $uri, $handler, $parameters);
    }

    /**
     * Adding route as POST to collection
     */
    public function post(string $uri, mixed $handler, array $parameters = []): void
    {
        $this->router->getCollection()->addRoute('POST', $uri, $handler, $parameters);
    }

    /**
     * Adding route as DELETE to collection
     */
    public function delete(string $uri, mixed $handler, array $parameters = []): void
    {
        $this->router->getCollection()->addRoute('DELETE', $uri, $handler, $parameters);
    }

    /**
     * Adding route as PUT to collection
     */
    public function put(string $uri, mixed $handler, array $parameters = []): void
    {
        $this->router->getCollection()->addRoute('PUT', $uri, $handler, $parameters);
    }

    /**
     * @throws HttpException
     */
    public function handle(?string $httpMethod = null, ?string $uri = null): DispatcherResult
    {
        return $this->router->handle(
            $httpMethod ?? ($_SERVER['REQUEST_METHOD'] ?? null), 
            $uri ?? ($_SERVER['REQUEST_URI'] ?? null)
        );
    }
}
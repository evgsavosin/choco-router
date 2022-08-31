<?php 

declare(strict_types=1);

namespace SimpleRouting;

use SimpleRouting\Attribute\AttributeLoader;
use SimpleRouting\Dispatcher\{Dispatcher, DispatcherResult};
use SimpleRouting\Exceptions\HttpException;

final class Router 
{
    use CreateRouteTrait;

    protected RouteCollection $collection;

    protected Dispatcher $dispatcher;

    protected AttributeLoader $loader;

    public function __construct()
    {
        $this->collection = new RouteCollection();
        $this->dispatcher = new Dispatcher($this->collection);
        $this->loader = new AttributeLoader($this);
    }

    public function getCollection(): RouteCollection
    {
        return $this->collection;
    }

    public function loadControllers(array $controllers): void
    {
        $attributes = $this->loader->load($controllers);
        
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
<?php 

declare(strict_types=1);

namespace ChocoRouter;

use ChocoRouter\Dispatcher\{Dispatcher, DispatcherInterface, DispatcherResult};
use ChocoRouter\Exceptions\HttpException;

/**
 * @since 1.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
final class Router 
{
    protected Dispatcher $dispatcher;

    public function __construct(
        protected RouteCollection $collection
    ) {
        $this->collection = $collection;
        $this->dispatcher = new Dispatcher($this->collection);
    }
    
    public function getCollection(): RouteCollection
    {
        return $this->collection;
    }

    public function getDispatcher(): DispatcherInterface
    {
        return $this->dispatcher;
    }

    /**
     * @throws HttpException
     */
    public function handle(?string $httpMethod = null, ?string $uri = null): DispatcherResult
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

        if (($result = $this->dispatcher->dispatch($httpMethod, $uri)) === null) {
            throw new HttpException('Route not found', HttpException::NOT_FOUND);
        }

        return $result;
    }
}
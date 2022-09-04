<?php 

declare(strict_types=1);

namespace ChocoRouter;

use ChocoRouter\Resolver\{Resolver, ResolverResult, ResolverInterface};
use ChocoRouter\Exceptions\HttpException;

use function strpos;
use function substr;
use function rawurldecode;

/**
 * @since 1.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
final class Router 
{
    protected Resolver $resolver;

    public function __construct(
        protected RouteCollection $collection
    ) {
        $this->collection = $collection;
        $this->resolver = new Resolver($this->collection);
    }
    
    public function getCollection(): RouteCollection
    {
        return $this->collection;
    }

    public function getResolver(): ResolverInterface
    {
        return $this->resolver;
    }

    /**
     * @throws HttpException
     */
    public function resolve(?string $httpMethod = null, ?string $uri = null): ResolverResult
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

        if (($result = $this->resolver->resolve($httpMethod, $uri)) === null) {
            throw new HttpException('Route not found', HttpException::NOT_FOUND);
        }

        return $result;
    }
}
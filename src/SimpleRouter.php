<?php 

declare(strict_types=1);

namespace ChocoRouter;

use ChocoRouter\Cache\{Cache, CacheKey, DisableCacheException};
use ChocoRouter\Resolver\ResolverResult;
use Closure;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
final class SimpleRouter 
{
    protected Router $router;

    protected SimpleConfiguration $configuration;

    protected ?Cache $cache = null;

    public function __construct(array $options = [])
    {
        $this->configuration = new SimpleConfiguration(...$options);

        if ($this->configuration->isCacheable()) {
            $this->cache = new Cache($this->configuration->getCacheDriver(), $this->configuration->getCacheOptions());
        }

        $collection = new RouteCollection();
        $this->router = new Router($collection);
    }

    public function getCollection(): RouteCollection
    {
        return $this->router->getCollection();
    }

    public function getCache(): mixed
    {
        return $this->cache;
    }

    public function cache(Closure $callback): mixed
    {
        if (!$this->configuration->isCacheable()) {
            throw new DisableCacheException('Cache is disabled.');
        }

        $data = $this->cache->get(CacheKey::ROUTES);

        if ($data === null) {
            $collection = $this->router->getCollection();
            $callback($collection);
            $data = $this->cache->set(CacheKey::ROUTES, $collection->getRoutes());
        }

        $this->router->getCollection()->fromArray($data);

        return $data;
    }

    public function clearCache(): void
    {
        $this->cache->clear();
    }

    public function addGroup(string $prefix, callable $callback): void
    {
        $this->router->getCollection()->addGroup($prefix, $callback);
    }

    public function addRoute(HttpMethod $httpMethod, string $uri, mixed $handler, array $parameters = []): void
    {
        $this->router->getCollection()->addRoute($httpMethod, $uri, $handler, $parameters);
    }

    /**
     * @throws HttpException
     */
    public function resolve(?string $httpMethod = null, ?string $uri = null): ResolverResult
    {
        return $this->router->resolve(
            $httpMethod ?? ($_SERVER['REQUEST_METHOD'] ?? null), 
            $uri ?? ($_SERVER['REQUEST_URI'] ?? null)
        );
    }
}
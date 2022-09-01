<?php 

declare(strict_types=1);

namespace ChocoRouter\Dispatcher;

use ChocoRouter\Route;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class DispatcherResult
{
    public function __construct(
        protected Route $route,
        protected string $uri,
        protected array $parameters = []
    ) {}

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getHandler(): mixed
    {
        return $this->route->getHandler();
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
<?php 

declare(strict_types=1);

namespace SimpleRouting;

/**
 * @since 1.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class Route
{
    public function __construct(
        protected string $httpMethod, 
        protected RouteExpression $expression, 
        protected mixed $handler, 
        protected array $parameters = []
    ) {}

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @since 2.0
     */
    public function getExpression(): RouteExpression
    {
        return $this->expression;
    }

    public function getHandler(): mixed
    {
        return $this->handler;
    }

    /**
     * @since 2.0
     */
    public function hasParameters(): bool
    {
        return $this->parameters !== [];
    }

    /**
     * @since 2.0
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
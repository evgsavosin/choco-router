<?php 

declare(strict_types=1);

namespace ChocoRouter;

use ChocoRouter\Traits\StateableTrait;

/**
 * @since 1.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class Route
{
    use StateableTrait;

    public function __construct(
        protected HttpMethod $httpMethod, 
        protected RouteExpression $expression, 
        protected mixed $handler, 
        protected array $parameters = []
    ) {}
    
    public function getHttpMethod(): HttpMethod
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
<?php 

declare(strict_types=1);

namespace SimpleRouting;

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
     * @deprecated This method is deprecated and remove in future version
     * @since 1.0
     */
    public function getUri(): string
    {
        return $this->expression->getPattern();
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
     * @deprecated This method is deprecated and remove in future version
     * @since 1.0
     */
    public function getRegex(): array
    {
        return $this->regex;
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
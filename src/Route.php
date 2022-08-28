<?php 

declare(strict_types=1);

namespace SimpleRouting;

class Route
{
    public function __construct(
        protected string $httpMethod, 
        protected RouteExpression $expression, 
        protected $handler, 
        protected ?array $regex = null
    ) {}

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @deprecated This method is deprecated and remove in future version
     */
    public function getUri(): string
    {
        return $this->expression->getPattern();
    }

    public function getExpression(): RouteExpression
    {
        return $this->expression;
    }

    public function getHandler(): callable|string
    {
        return $this->handler;
    }

    public function getRegex(): array
    {
        return $this->regex;
    }
}
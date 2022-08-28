<?php 

declare(strict_types=1);

namespace SimpleRouting;

class Route
{
    protected string $httpMethod;
    protected string $uri;
    protected $handler;
    protected array $regex = [];

    public function __construct(string $httpMethod, string|callable $uri, $handler, ?array $regex = null)
    {
        $this->httpMethod = $httpMethod;
        $this->uri = $uri;
        $this->handler = $handler;
        $this->regex = $regex;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getUri(): string
    {
        return $this->uri;
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
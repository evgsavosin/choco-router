<?php declare(strict_types=1);

namespace SimpleRouting;

class Route
{
    /**
     * HTTP Method (GET/PUT/POST/DELETE)
     * 
     * @var string $httpMethod
     */
    protected string $httpMethod;

    /**
     * @var string string $uri
     */
    protected string $uri;

    /**
     * Handler as callback or function
     * 
     * @var string|callable $handler
     */
    protected string $handler;

    /**
     * Regex rules
     * 
     * @var array $regex
     */
    protected array $regex = [];

    /**
     * Constructor
     * 
     * @param string $httpMethod
     * @param string $uri
     * @param string|callable $handler
     * @param array|null $regex
     * @return void
     */
    public function __construct(string $httpMethod, string $uri, $handler, ?array $regex = null)
    {
        $this->httpMethod = $httpMethod;
        $this->uri = $uri;
        $this->handler = $handler;
        $this->regex = $regex;
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return callable|string
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return array
     */
    public function getRegex(): array
    {
        return $this->regex;
    }
}
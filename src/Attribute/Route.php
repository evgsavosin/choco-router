<?php 

declare(strict_types=1);

namespace ChocoRouter\Attribute;

use ChocoRouter\HttpMethod;
use Attribute;

/**
 * Route attribute
 * 
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Route 
{
    public function __construct(
        private HttpMethod $httpMethod,
        private string $uri,
        private mixed $parameters = []
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return $this->httpMethod;
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
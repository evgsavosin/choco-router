<?php 

declare(strict_types=1);

namespace SimpleRouting\Matcher;

use SimpleRouting\RouteExpression;

interface MatcherInterface
{
    public function match(string $expression, array $params = []): RouteExpression;
}
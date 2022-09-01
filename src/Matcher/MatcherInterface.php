<?php 

declare(strict_types=1);

namespace SimpleRouting\Matcher;

use SimpleRouting\RouteExpression;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
interface MatcherInterface
{
    public function match(string $expression, array $params = []): RouteExpression;
}
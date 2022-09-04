<?php 

declare(strict_types=1);

namespace ChocoRouter\Resolver;

/**
 * Resolver interface for resolve entry request
 * 
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
interface ResolverInterface
{
    public function resolve(string $httpMethod, string $uri): ?ResolverResult;
}
<?php 

declare(strict_types=1);

namespace SimpleRouting\Dispatcher;

/**
 * Dispatcher interface for dispatch entry request for router
 * 
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
interface DispatcherInterface
{
    public function dispatch(string $httpMethod, string $uri): ?DispatcherResult;
}
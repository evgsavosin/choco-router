<?php 

declare(strict_types=1);

namespace SimpleRouting\Dispatcher;

interface DispatcherInterface
{
    public function handle(string $httpMethod, string $uri): ?DispatcherResult;
}
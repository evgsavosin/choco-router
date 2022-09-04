<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache\Drivers;

use ChocoRouter\Cache\CacheKey;

interface DriverInterface
{
    public function get(string $key): mixed;

    public function set(string $key, mixed $value): mixed;

    public function delete(string $key);
}
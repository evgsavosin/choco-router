<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache\Drivers;

use ChocoRouter\Cache\CacheKey;

interface DriverInterface
{
    public function get(CacheKey $key): mixed;

    public function set(CacheKey $key, mixed $value): mixed;

    public function delete(CacheKey $key);
}
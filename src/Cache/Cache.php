<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache;

use ChocoRouter\Cache\Drivers\DriverInterface;
use Closure;
use InvalidArgumentException;

class Cache
{
    protected DriverInterface $driver;

    public function __construct(string $driverClass) 
    {
        $this->driver = new $driverClass;

        if (!($this->driver instanceof DriverInterface)) {
            throw new InvalidArgumentException('Cache driver must be implements driver interface.');
        }
    }

    public function getDriver(): DriverInterface
    {
        return $this->driver;
    }

    public function get(CacheKey $key): mixed
    {
        return $this->driver->get($key);
    }

    public function set(CacheKey $key, mixed $value): mixed
    {
        return $this->driver->set($key, $value);
    }

    public function delete(CacheKey $key): void
    {
        $this->driver->delete($key);
    }

    public function clear(): void
    {
        foreach (CacheKey::cases() as $key) {
            $this->driver->delete($key);
        }
    }
}
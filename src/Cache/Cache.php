<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache;

use ChocoRouter\Cache\Drivers\DriverInterface;
use InvalidArgumentException;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class Cache
{
    protected DriverInterface $driver;

    public function __construct(string $driverClass, array $options = []) 
    {
        $this->driver = new $driverClass(...$options);

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
        return $this->driver->get($key->value);
    }

    public function set(CacheKey $key, mixed $value): mixed
    {
        return $this->driver->set($key->value, $value);
    }

    public function delete(CacheKey $key): void
    {
        $this->driver->delete($key->value);
    }

    public function clear(): void
    {
        foreach (CacheKey::cases() as $key) {
            $this->driver->delete($key->value);
        }
    }
}
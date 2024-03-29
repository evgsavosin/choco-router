<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache\Drivers;

use ChocoRouter\Cache\NotInstalledDriverException;
use InvalidArgumentException;
use Memcached;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
final class MemcachedDriver implements DriverInterface
{
    /** @var string NAME */
    public const NAME = 'memcached';

    protected Memcached $memcached;

    public function __construct(array $servers = [])
    {
        if (!extension_loaded(self::NAME)) {
            throw new NotInstalledDriverException('Memcached extension is not installed.');
        }  

        if ($servers === []) {
            throw new InvalidArgumentException('Servers was not listed.');
        }

        $this->memcached = new Memcached();
        
        if ($this->memcached->addServers($servers) === false) {
            throw new InvalidArgumentException('Servers is not available.');
        }
    }

    public function get(string $key): mixed
    {
        $data = $this->memcached->get($key);

        if ($data === false) {
            return null;
        }

        return $data;
    }

    public function set(string $key, mixed $value): mixed
    {
        $this->memcached->set($key, $value);

        return $value;
    }

    public function delete(string $key): void
    {
        $this->memcached->delete($key);
    }
}
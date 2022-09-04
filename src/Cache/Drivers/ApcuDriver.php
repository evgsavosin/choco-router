<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache\Drivers;

use function apcu_fetch;
use function apcu_store;
use function apcu_delete;

final class ApcuDriver implements DriverInterface
{
    public function get(string $key): mixed
    {
        $data = apcu_fetch($key, $success);

        if (!$success || $data === false) {
            return null;
        }

        return $data;
    }

    public function set(string $key, mixed $value): mixed
    {
        apcu_store($key, $value);
        
        return $value;
    }

    public function delete(string $key): void
    {
        apcu_delete($key);
    }
}
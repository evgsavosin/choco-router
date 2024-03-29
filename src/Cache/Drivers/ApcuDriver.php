<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache\Drivers;

use ChocoRouter\Cache\NotInstalledDriverException;

use function apcu_fetch;
use function apcu_store;
use function apcu_delete;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
final class ApcuDriver implements DriverInterface
{
    /** @var string NAME */
    public const NAME = 'apcu';

    public function __construct()
    {
        if (!extension_loaded(self::NAME)) {
            throw new NotInstalledDriverException('APCu extension is not installed.');
        }  

        if (!apcu_enabled()) {
            throw new NotInstalledDriverException('APCu extension is not enabled.');
        }
    }

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
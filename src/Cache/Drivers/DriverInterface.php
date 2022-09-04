<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache\Drivers;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
interface DriverInterface
{
    public function get(string $key): mixed;

    public function set(string $key, mixed $value): mixed;

    public function delete(string $key);
}
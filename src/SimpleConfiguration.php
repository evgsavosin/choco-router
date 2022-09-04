<?php 

declare(strict_types=1);

namespace ChocoRouter;

use ChocoRouter\Cache\Drivers\FileDriver;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class SimpleConfiguration
{
    public function __construct(
        private bool $cacheDisable = false,
        private string $cacheDriver = FileDriver::class
    ) {}

    public function isCacheable(): bool
    {
        return !$this->cacheDisable;
    }

    public function getCacheDriver(): string
    {
        return $this->cacheDriver;
    }
}
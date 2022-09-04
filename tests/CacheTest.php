<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use ChocoRouter\Cache\Cache;
use ChocoRouter\Cache\CacheKey;
use ChocoRouter\Cache\Drivers\ApcuDriver;
use ChocoRouter\Cache\Drivers\FileDriver;
use ChocoRouter\Cache\Drivers\MemcachedDriver;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;
use function extension_loaded;

final class СacheTest extends TestCase
{
    public function testCacheViaFileDriver(): void
    {
        $cache = new Cache(FileDriver::class);
        $data = $cache->get(CacheKey::TEST);

        if ($data === null) {
            $data = $cache->set(CacheKey::TEST, ['foo' => 'bar', 'baz' => 'quux']);
        }

        assertEquals($data, ['foo' => 'bar', 'baz' => 'quux']);
    }

    public function testCacheViaApcuDriver(): void
    {
        if (!extension_loaded(ApcuDriver::NAME)) {
            assertTrue(true);
            return;
        }

        $cache = new Cache(ApcuDriver::class);
        $data = $cache->get(CacheKey::TEST);

        if ($data === null) {
            $data = $cache->set(CacheKey::TEST, ['foo' => 'bar', 'baz' => 'quux']);
        }

        assertEquals($data, ['foo' => 'bar', 'baz' => 'quux']);
    }

    public function testCacheViaMemcachedDriver(): void
    {
        if (!extension_loaded(MemcachedDriver::NAME)) {
            assertTrue(true);
            return;
        }

        $cache = new Cache(MemcachedDriver::class);
        $data = $cache->get(CacheKey::TEST);

        if ($data === null) {
            $data = $cache->set(CacheKey::TEST, ['foo' => 'bar', 'baz' => 'quux']);
        }

        assertEquals($data, ['foo' => 'bar', 'baz' => 'quux']);
    }
}
<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use ChocoRouter\Cache\Cache;
use ChocoRouter\Cache\CacheKey;
use ChocoRouter\Cache\Drivers\ApcuDriver;
use ChocoRouter\Cache\Drivers\FileDriver;
use ChocoRouter\Cache\Drivers\MemcachedDriver;
use ChocoRouter\Cache\NotInstalledDriverException;
use InvalidArgumentException;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsObject;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

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
}
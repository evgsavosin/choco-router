<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use ChocoRouter\Cache\Cache;
use ChocoRouter\Cache\CacheKey;
use ChocoRouter\Cache\Drivers\FileDriver;

use function PHPUnit\Framework\assertEquals;

final class СacheTest extends TestCase
{
    public function testCacheViaFileDriver(): void
    {
        $cache = new Cache(FileDriver::class);
        $data = $cache->get(CacheKey::TEST);

        if ($data === null) {
            $data = $cache->set(CacheKey::TEST, $data);
        }

        assertEquals($data, ['foo' => 'bar', 'baz' => 'quux']);
    }
}
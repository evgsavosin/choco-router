<?php 

declare(strict_types=1);

namespace Tests;

use ChocoRouter\Cache\Drivers\FileDriver;
use ChocoRouter\SimpleConfiguration;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

final class ConfigurationTest extends TestCase
{
    public function testConfiguration(): void
    {
        $configuration = new SimpleConfiguration(
            cacheDisable: false,
            cacheDriver: FileDriver::class
        );

        assertTrue($configuration->isCacheable());
        assertEquals($configuration->getCacheDriver(), FileDriver::class);
    }
}
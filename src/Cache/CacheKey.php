<?php 

declare(strict_types=1);

namespace ChocoRouter\Cache;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
enum CacheKey: string {
    case TEST = 'test';
    case ROUTES = 'routes';
}
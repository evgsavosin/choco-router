<?php 

declare(strict_types=1);

namespace ChocoRouter;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
enum HttpMethod: string {
    CASE CONNECT = 'CONNECT';
    CASE HEAD = 'HEAD';
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case OPTIONS = 'OPTIONS';
}
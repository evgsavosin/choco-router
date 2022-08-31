<?php 

declare(strict_types=1);

namespace SimpleRouting\Exceptions;

use Exception;

final class HttpException extends Exception
{
    /** @var int NOT_FOUND */
    final public const NOT_FOUND = 404;

    /** @var int BAD_REQUEST */
    final public const BAD_REQUEST = 400;
}
<?php 

declare(strict_types=1);

namespace SimpleRouting\Exception;

use Exception;

final class HttpException extends Exception
{
    /**
     * @var int NOT_FOUND
     */
    public const NOT_FOUND = 404;
}
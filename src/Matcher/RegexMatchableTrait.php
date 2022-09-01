<?php 

declare(strict_types=1);

namespace SimpleRouting\Matcher;

use function preg_match;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
trait RegexMatchableTrait
{
    public function isRegexPatternValid(string $pattern): bool
    {
        return preg_match("~{$pattern}~", '') !== false;
    }
}
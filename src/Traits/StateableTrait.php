<?php 

declare(strict_types=1);

namespace ChocoRouter\Traits;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
trait StateableTrait
{
    public static function __set_state(array $properties): self
    {
        return new self(...$properties);
    }
}
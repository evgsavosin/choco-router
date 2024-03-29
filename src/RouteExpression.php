<?php 

declare(strict_types=1);

namespace ChocoRouter;

use ChocoRouter\Traits\StateableTrait;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class RouteExpression
{
    use StateableTrait;

    public function __construct(
        protected string $value,
        protected ?string $pattern = null,
        protected bool $isStatic = false
    ) {}

    public function getValue(): string
    {
        return $this->value;
    }

    public function getPattern(): string
    {
        if ($this->isStatic()) {
            return $this->getValue();
        }

        return "~^{$this->pattern}$~";
    }

    public function isStatic(): bool
    {
        return $this->isStatic;
    }
}
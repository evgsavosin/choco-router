<?php 

declare(strict_types=1);

namespace SimpleRouting\Matcher;

use function strlen;
use function substr;
use function sprintf;

class Parameter
{
    use RegexMatchableTrait;

    /** @var int MAX_NAME_LENGTH */
    final public const MAX_NAME_LENGTH = 32;

    /** @var string VALUE_PATTERN */
    final public const VALUE_PATTERN = '[^/]+';

    protected bool $isRequired = true;

    public function __construct(
        protected string $name,
        protected ?string $pattern
    ) {
        $this->parse($name, $pattern);

        if (!$this->isRegexPatternValid($this->pattern)) {
            throw new BadParameterException("Parameter {$this->name} has invalid regex pattern: {$this->pattern}.");
        }

        if (!$this->isRequired()) {
            $this->pattern = "({$this->pattern})?";
        }
    }

    protected function parse(string $name, ?string $pattern): void
    {
        if (($length = strlen($name) - 1) > static::MAX_NAME_LENGTH) {
            throw new BadParameterException(sprintf('Maximum parameter name length is %d.', static::MAX_NAME_LENGTH));
        }

        $this->isRequired = $name[$length] !== '?';
        $this->name = $this->isRequired ? $name : substr($name, 0, $length);
        $this->pattern = $pattern ?? static::VALUE_PATTERN;
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }
}
<?php 

declare(strict_types=1);

namespace SimpleRouting\Matcher;

use SimpleRouting\RouteExpression;

use function preg_replace_callback;
use function preg_match;
use function preg_quote;

/**
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
class Matcher implements MatcherInterface
{
    use RegexMatchableTrait;

    /** @var string PARAMETER_PATTERN */
    final public const PARAMETER_PATTERN = '\{([a-zA-Z0-9?]+)\}';

    /**
     * @throws BadParameterException
     * @throws BadExpressionException
     */
    public function match(string $expression, array $params = []): RouteExpression
    {
        if (!$this->hasParameters($expression)) {
            return new RouteExpression(
                $expression, 
                isStatic: true
            );
        }

        $pattern = $this->matchParameters(
            $this->validate($expression), 
            $params
        );

        if (!$this->isRegexPatternValid($pattern)) {
            throw new BadExpressionException('Incorrect route expression pattern.');
        }

        return new RouteExpression($expression, $pattern);
    }

    protected function hasParameters(string $expression): bool
    {
        return (bool) preg_match('~' . self::PARAMETER_PATTERN . '~', $expression);
    }

    /**
     * @throws BadExpressionException
     */
    protected function validate(string $expression): string
    {
        if ($expression === '') {
            throw new BadExpressionException('Route expression not must be empty.');
        }

        return preg_replace_callback(
            '~' . self::PARAMETER_PATTERN . '(*SKIP)(*FAIL)||[^{}]+~',
            fn ($matches): string => preg_quote($matches[0], '~'),
            $expression
        );
    }

    /**
     * @throws BadParameterException
     */
    protected function matchParameters(string $expression, array $parameters): string
    {
        $forbidRequired = false;

        return preg_replace_callback(
            '~' . self::PARAMETER_PATTERN . '~', 
            function ($matches) use (&$parameters, &$forbidRequired): string {
                $parameter = new Parameter($matches[1], $parameters[$matches[1]] ?? null);

                if (!$parameter->isRequired()) {
                    $forbidRequired = true;
                } else if ($forbidRequired) {
                    throw new BadParameterException('Required parameters not allowed after optional parameter.');
                }

                return (!$parameter->isRequired() ? '?' : '') . $parameter->getPattern();
            }, 
            $expression
        );
    }
}
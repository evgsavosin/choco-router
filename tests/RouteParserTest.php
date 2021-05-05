<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SimpleRouting\RouteParser;

final class RouteParserTest extends TestCase
{
    public function testRouteParsing(): void
    {
        $routeParser = new RouteParser;

        $uri = '/foo/bar/{baz?}';
        $regexExpression = ['baz' => '[0-9]'];

        $this->assertStringContainsString(
            $routeParser->make($uri, $regexExpression), 
            '~^\/foo\/bar\/([0-9]+)?$~'
        );
    }
}
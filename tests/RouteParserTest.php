<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use SimpleRouting\Matcher\{Matcher, MatcherInterface};

final class RouteParserTest extends TestCase
{
    protected MatcherInterface $matcher;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->matcher = new Matcher();    
    }

    public function testSimpleRouteMatching(): void
    {
        $expression = $this->matcher->match(
            '/foo/bar/{baz}/{quux}/{bat?}', 
            [
                'baz' => '[0-9]+',
                'quux' => '[a-zA-Z]+'
            ]
        );

        $this->assertMatchesRegularExpression($expression->getPattern(), '/foo/bar/5/gorge/15');
    }

    public function testRealRouteMatching(): void
    {
        $routes = [
            '/users/create' => '/users/create',
            '/users/{id}' => '/users/1',
            '/users/{id}/comments' => '/users/1/comments',
            '/users/{id}/update' => '/users/1/update',
            '/users/{id}/delete' => '/users/1/delete',
            '/users/{id}/comments/{id?}' => '/users/1/comments'
        ];

        foreach ($routes as $expected => $actual) {
            $expression = $this->matcher->match($expected);

            if ($expression->isStatic()) {
                $this->assertSame($expected, $actual);
            } else {
                $this->assertMatchesRegularExpression(
                    $this->matcher->match($expected)->getPattern(), 
                    $actual
                );
            }
        
        }
    }
}
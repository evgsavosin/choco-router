<?php declare(strict_types=1);

namespace SimpleRouting;

use SimpleRouting\Exception\BadRouteException;

final class RouteParser
{
    /**
     * Replace magic variables in uri with a regex expression
     * Example: 
     * Uri: /test/{simple}, regex array ['simple' => ['[a-zA-Z]']], finalize - ~\/test\/[a-zA-Z]~
     * 
     * @param string $uri
     * @param array|null $regex
     * 
     * @throws BadRouteException
     * 
     * @return string
     */
    public function make(string $uri, ?array &$regex = null): string
    {
        if ($regex === null) {
            $regex = [];
        }

        $requiredSkipSlash = false;

        // Escape slashes
        if (!empty($regex)) {
            $uri = str_replace('/', '\/', $uri);
        }

        // Replace placeholders to real regex expression
        $uri = preg_replace_callback('~\{([a-zA-Z0-9?]+)\}~', function ($matches) use (&$regex, &$requiredSkipSlash) {
            $matches = $matches[1];

            if (($requiredSignPos = strpos($matches, '?', strlen($matches) - 1)) !== false) {
                $matches = substr($matches, 0, $requiredSignPos);
            }

            if (!array_key_exists($matches, $regex)) {
                $regex[$matches] = '[^/]';
            }

            $pattern = (($requiredSignPos !== false && $requiredSkipSlash) ? '?' : '') . 
                '(' . $regex[$matches] . '+)' . 
                ($requiredSignPos !== false ? '?' : '+');

            $requiredSkipSlash = $requiredSignPos !== false;

            return $pattern;
        }, $uri);

        if (!empty($regex)) {
            if ($requiredSkipSlash && $uri[strlen($uri) - 1] == '/') {
                $uri .= '?';
            }
            
            $uri = '~^' . $uri . '$~';

            // Test regex expression
            if (preg_match($uri, '') === false) {
                throw new BadRouteException('Incorrect regex expression');
            }
        }

        return $uri;
    }
}
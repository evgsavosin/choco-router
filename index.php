<?php

require_once 'vendor/autoload.php';

ini_set('display_errors', 'on');
error_reporting(E_ALL);

// ------

use SimpleRouting\Router;
use SimpleRouting\Exception\HttpException;

$router = new Router;

$router->get('/foo/bar', 'foo-bar');
$router->post('/foo/{bar}', 'foo-bar');
$router->get('/foo/bar/{foo}/{bar}/?{baz?}', 'foo-bar-baz', [
    'foo' => '[0-9]',
    'bar' => '[a-zA-Z]'
]);

try {
    $result = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    var_dump($result);exit;
} catch (HttpException $e) {
    if ($e->getCode() == HttpException::NOT_FOUND) {
        echo $e->getCode();
    }
}
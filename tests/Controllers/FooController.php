<?php 

declare(strict_types=1);

namespace Tests\Controllers;

use ChocoRouter\Attribute\Route;
use ChocoRouter\HttpMethod;

final class FooController 
{
    #[Route(HttpMethod::GET, '/foo')]
    public function foo(): void
    {
        
    }

    #[Route(HttpMethod::POST, '/bar')]
    public function bar(): void
    {
        
    }
}
<?php 

declare(strict_types=1);

namespace Tests\Controllers;

use ChocoRouter\Attribute\Route;

final class FooController 
{
    #[Route('GET', '/foo')]
    public function foo(): void
    {
        
    }

    #[Route('GET', '/bar')]
    public function bar(): void
    {
        
    }
}
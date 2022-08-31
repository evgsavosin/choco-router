<?php 

declare(strict_types=1);

namespace SimpleRouting\Attribute;

interface AttributeLoaderInterface
{
    public function load(array $controllers): void;
}
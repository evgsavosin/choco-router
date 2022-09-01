<?php 

declare(strict_types=1);

namespace SimpleRouting\Attribute;

/**
 * Attribute loader implementation for MVC (controllers, actions and etc.)
 * 
 * @since 2.0
 * @author Evgeny Savosin <evg@savosin.dev>
 */
interface AttributeLoaderInterface
{
    /**
     * Loading classes and create routes by existing attributes
     */
    public function load(array $classes): void;
}
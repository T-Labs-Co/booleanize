<?php

namespace TLabsCo\Booleanize\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TLabsCo\Booleanize\Booleanize
 */
class Booleanize extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \TLabsCo\Booleanize\Booleanize::class;
    }
}

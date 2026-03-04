<?php

namespace Smartdato\InPost\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Smartdato\InPost\InPost
 */
class InPost extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Smartdato\InPost\InPost::class;
    }
}

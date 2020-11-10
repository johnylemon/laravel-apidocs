<?php

namespace Johnylemon\Apidocs\Facades;

use Illuminate\Support\Facades\Facade;

class Apidocs extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Johnylemon\Apidocs\Apidocs::class;
    }
}

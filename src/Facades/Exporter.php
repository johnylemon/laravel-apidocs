<?php

namespace Johnylemon\Apidocs\Facades;

use Illuminate\Support\Facades\Facade;

class Exporter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return config('apidocs.exporter');
    }
}

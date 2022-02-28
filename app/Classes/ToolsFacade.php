<?php

namespace App\Classes;

use Illuminate\Support\Facades\Facade;

class ToolsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tools';
    }
}

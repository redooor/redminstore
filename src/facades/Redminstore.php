<?php

namespace Redooor\Redminstore\Facades;

use Illuminate\Support\Facades\Facade;

class Redminstore extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'redminstore';
    }
}

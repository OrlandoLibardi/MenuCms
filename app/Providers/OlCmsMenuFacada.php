<?php

namespace OrlandoLibardi\MenuCms\app\Providers;

use Illuminate\Support\Facades\Facade;

class OlCmsMenuFacada extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'OlCmsMenu';
    }
}
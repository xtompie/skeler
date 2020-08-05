<?php

namespace App\Admin\Resource;

use ReflectionClass;

class ResourceManager
{

    public static function resources()
    {
        return collect(config('admin.resources'))
            ->map(function($i) {
                return (new ReflectionClass($i))->newInstance();
            })
        ;
    }

}

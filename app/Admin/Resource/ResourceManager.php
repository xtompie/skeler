<?php

namespace App\Admin\Resource;

use ReflectionClass;

class ResourceManager
{

    public static function resources()
    {
        return collect(config('admin.resources'))
            ->mapWithKeys(function($i) {
                $resource = (new ReflectionClass($i))->newInstance();
                return [$resource->key() => $resource];
            })
        ;
    }

    public static function resource($name)
    {
        return self::resources()[$name];
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \App\Admin\Resource\Resource
     */
    public static function resourceByRequest($request)
    {
        $resource = self::resource($request->route()->getAction()['resource']);
        return $resource ? $resource->withRequest($request) : null;
    }

    public static function each()
    {
        return self::resources()->each;
    }

}

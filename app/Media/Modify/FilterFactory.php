<?php

namespace App\Media\Modify;

class FilterFactory
{

    public function __invoke($name)
    {
        $config = config("media.modify.filter.$name");
        if (!$config || !$config['type']) {
            return null;
        }
        return method_exists($this, $config['type'])
            ? $this->{$config['type']}($config)
            : null;
    }

    public function crop($config)
    {
        return new CropFilter($config['w'], $config['h']);
    }

    public function resize($config)
    {
        return new ResizeFilter($config['w'], $config['h']);
    }

}

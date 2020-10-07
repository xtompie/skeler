<?php

namespace App\Media\Spawn;

use Illuminate\Support\Str;

class Spawn
{

    public static function invoke($mainType, $subType, $name = null)
    {
        $random = Str::lower(Str::uuid());

        return
            Str::slug($mainType)
            . '/' . Str::slug($subType)
            . '/' . substr($random, 0, 2)
            . '/' . substr($random, 2, 2)
            . '/' . substr($random, 4, 2)
            . '/' . $random . (strlen($name) ?  '_' . Str::slug($name) : '')
        ;
    }

}

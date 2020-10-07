<?php

namespace App\Media\Util;

use Illuminate\Support\Str;

class EnsureDirForFile
{

    public static function invoke($filepath)
    {
        EnsureDir::invoke(dirname($filepath));
    }

}

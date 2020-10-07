<?php

namespace App\Media\Util;

class EnsureDir
{

    public static function invoke($dir)
    {
        if (file_exists($dir)) {
            return;
        }

        mkdir($dir, 0777, true);
    }

}

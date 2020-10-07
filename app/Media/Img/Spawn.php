<?php

namespace App\Media\Img;

use App\Media\Spawn\Spawn as BaseSpawn;

class Spawn
{

    public static function invoke($type, $name = null)
    {
        $ext = null;

        // extract extension from name for normalization, BaseSpawn removes dots from name
        if ($name !== null) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $name = substr($name, 0, - strlen($ext) - 1); // -1 for dot character before extentsion
            // normalize extension
            $ext = mb_strtolower($ext);
            if ($ext === 'jpeg') {
                $ext = 'jpg';
            }
            $ext = ".$ext";

        }

        return BaseSpawn::invoke('img', $type, $name) . $ext;
    }

}

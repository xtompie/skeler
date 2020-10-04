<?php

namespace App\Media\Modify;

use Illuminate\Support\Facades\Storage as StorageDisk;

class Storage
{

    public static function make()
    {
        return StorageDisk::disk('local');
    }

}

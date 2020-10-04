<?php

namespace App\Media\Modify;

use \Illuminate\Filesystem\Filesystem;

interface FilterInterface
{

    public function __invoke(Filesystem $storage, $input, $output);

}

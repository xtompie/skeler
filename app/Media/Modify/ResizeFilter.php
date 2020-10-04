<?php

namespace App\Media\Modify;

use Illuminate\Filesystem\Filesystem;

class ResizeFilter implements FilterInterface
{

    protected $width;
    protected $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function __invoke(Filesystem $storage, $input, $output)
    {
        $storage->copy($input, $output);
    }

}

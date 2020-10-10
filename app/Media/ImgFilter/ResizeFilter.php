<?php

namespace App\Media\ImgFilter;

use Intervention\Image\Facades\Image;

class ResizeFilter implements FilterInterface
{

    protected $width;
    protected $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function __invoke($input, $output)
    {
        Image::make($input)->resize($this->width, $this->height)->save($output);
    }

}

<?php

namespace App\Media\ImgFilter;

use Intervention\Image\Facades\Image;
use App\Media\Util\EnsureDirForFile;

class CropFilter implements FilterInterface
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
        EnsureDirForFile::invoke($output);
        Image::make($input)->fit($this->width, $this->height)->save($output);
    }

}

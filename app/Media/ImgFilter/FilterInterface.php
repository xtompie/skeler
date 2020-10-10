<?php

namespace App\Media\ImgFilter;

interface FilterInterface
{

    public function __invoke($input, $output);

}

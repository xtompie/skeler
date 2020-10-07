<?php

namespace App\Media\Modify;

interface FilterInterface
{

    public function __invoke($input, $output);

}

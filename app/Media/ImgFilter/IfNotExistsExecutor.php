<?php

namespace App\Media\ImgFilter;

class IfNotExistsExecutor
{

    public function __invoke(Formula $formula)
    {
        $output = storage_path($formula->output());

        if (file_exists($output)) {
            return true;
        }

        return (new Executor())->__invoke($formula);
    }

}

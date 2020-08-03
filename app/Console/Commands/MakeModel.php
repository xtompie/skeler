<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;

class ModelMake extends ModelMakeCommand
{

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Models';
    }

}

<?php

namespace App\Media\Modify;

class UnlessPersistsExecutor
{

    public function __invoke(Formula $formula)
    {
        $storage = Storage::make();

        if ($storage->exists($formula->output())) {
            return true;
        }

        return (new Executor())->__invoke($formula);
    }

}

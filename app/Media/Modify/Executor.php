<?php

namespace App\Media\Modify;

class Executor
{

    public function __invoke(Formula $formula)
    {

        $storage = Storage::make();

        if (!$storage->exists($formula->input())) {
            return false;
        }

        $filter = (new FilterFactory())->__invoke($formula->filter());

        if (!$filter instanceof FilterInterface) {
            return false;
        }

        $filter($storage, $formula->input(), $formula->output());

        if (!$storage->exists($formula->output())) {
            return false;
        }

        return true;
    }

}

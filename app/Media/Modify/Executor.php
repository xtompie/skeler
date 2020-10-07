<?php

namespace App\Media\Modify;

class Executor
{

    public function __invoke(Formula $formula)
    {
        $input = storage_path($formula->input());
        $output = storage_path($formula->output());

        if (!file_exists($input)) {
            return false;
        }

        $filter = (new FilterFactory())->__invoke($formula->filter());

        if (!$filter instanceof FilterInterface) {
            return false;
        }

        $filter($input, $output);

        if (!file_exists($output)) {
            return false;
        }

        return true;
    }

}

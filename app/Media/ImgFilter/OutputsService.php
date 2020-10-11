<?php

namespace App\Media\ImgFilter;

class OutputsService
{

    /**
     *  Rerturs all possible outputs for given url
     *
     * @param string $input
     * @return array All possible outputs
     */
    public function __invoke($input)
    {
        return collect(config("media.imgfilter.filter"))
            ->keys()
            ->map(function($filter) use ($input) {
                return FormulaByInputFactory::invoke($input, $filter);
            })
            ->filter()
            ->map(function(Formula $formula) {
                return $formula->output();
            })
            // ->map(function($output) {
            //     return storage_path($output);
            // })
            ->toArray()
        ;

    }

}

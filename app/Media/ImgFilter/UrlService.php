<?php

namespace App\Media\ImgFilter;

class UrlService
{

    /**
     *  Generates filtered img
     *
     * @param string $url
     * @return Formula|null
     */
    public function __invoke($url)
    {
        $formula = FormulaByUrlFactory::invoke($url);

        if (!$formula) {
            return null;
        }

        if (!(new IfNotExistsExecutor)->__invoke($formula)) {
            return null;
        }


        return storage_path($formula->output());
    }

}

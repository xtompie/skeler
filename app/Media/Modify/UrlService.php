<?php

namespace App\Media\Modify;

class UrlService
{

    /**
     *  Url process
     *
     * @param string $url
     * @return Formula|null
     */
    public static function invoke($url)
    {
        return (new static)->__invoke($url);
    }

    /**
     *  Url process
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

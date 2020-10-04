<?php

namespace App\Media\Modify;

class UrlProcess
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
        $formula = (new FormulaFactory)->forUrl($url);

        if (!$formula) {
            return null;
        }

        dd($formula);

        $executed = (new UnlessPersistsExecutor)->__invoke($formula);
        if (!$executed) {
            return null;
        }

        return $formula;
    }

}

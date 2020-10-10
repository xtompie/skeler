<?php

namespace App\Media\Modify;

class FormulaByUrlFactory
{

    /**
     * Creates formula for url
     *
     * @param string $url Url path
     * @return Formula|null
     */
    public static function invoke($url)
    {
        $parts = FormulaMatcher::invoke($url, [
            FormulaMatcher::URL_PREFIX,
            FormulaMatcher::MAIN,
            FormulaMatcher::FILTER,
            FormulaMatcher::EXT,
        ]);

        if (!$parts) {
            return null;
        }

        return new Formula(
            "{$parts->inputPrefix()}/{$parts->main()}.{$parts->ext()}",
            "{$parts->outputPrefix()}/{$parts->main()}_{$parts->filter()}.{$parts->ext()}",
            $parts->filter(),
            "{$parts->urlPrefix()}/{$parts->main()}_{$parts->filter()}.{$parts->ext()}"
        );
    }

}

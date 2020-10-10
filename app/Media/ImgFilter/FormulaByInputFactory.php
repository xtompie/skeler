<?php

namespace App\Media\ImgFilter;

class FormulaByInputFactory
{

    /**
     * Creates formula for input and filter
     *
     * @param string $path Input path
     * @param string $filter Filter name
     * @return Formula|null
     */
    public static function invoke($input, $filter)
    {
        if (!FormulaMatcher::invoke("_$filter", [FormulaMatcher::FILTER])) {
            return null;
        }

        $parts = FormulaMatcher::invoke($input, [
            FormulaMatcher::INPUT_PREFIX,
            FormulaMatcher::MAIN,
            FormulaMatcher::EXT,
        ]);

        if (!$parts) {
            return null;
        }

        return new Formula(
            "{$parts->inputPrefix()}/{$parts->main()}.{$parts->ext()}",
            "{$parts->outputPrefix()}/{$parts->main()}_{$filter}.{$parts->ext()}",
            $filter,
            "{$parts->urlPrefix()}/{$parts->main()}_{$filter}.{$parts->ext()}"
        );
    }

}

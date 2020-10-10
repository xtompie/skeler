<?php

namespace App\Media\ImgFilter;

class FormulaByOutputFactory
{

    /**
     * Creates formula for output
     *
     * @param string $path Output path
     * @return Formula|null
     */
    public static function invoke($output)
    {
        $parts = FormulaMatcher::invoke($output, [
            FormulaMatcher::OUTPUT_PREFIX,
            FormulaMatcher::MAIN,
            FormulaMatcher::FILTER,
            FormulaMatcher::EXT,
        ]);

        if (!$parts) {
            null;
        }

        return new static(
            "{$parts->inputPrefix()}/{$parts->main()}.{$parts->ext()}",
            "{$parts->outputPrefix()}/{$parts->main()}_{$parts->filter()}.{$parts->ext()}",
            $parts->filter(),
            "{$parts->urlPrefix()}/{$parts->main()}_{$parts->filter()}.{$parts->ext()}"
        );
    }


}

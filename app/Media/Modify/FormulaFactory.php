<?php

namespace App\Media\Modify;

class FormulaFactory
{

    /**
     * Creates formula
     *
     * @param string $path
     * @param string $filter
     * @return Formula|null
     */
    public static function makeForInput($input, $filter)
    {
        return (new static)->forInput($input, $filter);
    }

    /**
     * Creates formula
     *
     * @param string $path
     * @return Formula|null
     */
    public static function makeForOutput($output)
    {
        return (new static)->forOutput($output);
    }

    /**
     * Creates formula
     *
     * @param string $url
     * @return Formula|null
     */
    public static function makeForUrl($url)
    {
        return (new static)->forUrl($url);
    }

    /**
     * Creates formula
     *
     * @param string $path
     * @param string $filter
     * @return Formula|null
     */
    public function forInput($input, $filter)
    {
        if (!$this->match(['filter_name'], $filter)) {
            return null;
        }

        $parts = $this->match(['input_prefix', 'name', 'ext'], $input);
        if (!$parts) {
            return null;
        }

        return new Formula(
            "{$this->inputPrefix()}/{$parts->name}.{$parts->ext}",
            "{$this->outputPrefix()}/{$parts->name}_{$filter}.{$parts->ext}",
            $filter,
            "{$this->urlPrefix()}/{$parts->name}_{$filter}.{$parts->ext}"
        );
    }

    /**
     * Creates formula
     *
     * @param string $path
     * @return Formula|null
     */
    public function forOutput($output)
    {
        $parts = $this->match(['output_prefix', 'name', 'filter', 'ext'], $output);

        if (!$parts) {
            null;
        }

        return new static(
            "{$this->inputPrefix()}/{$parts->name}.{$parts->ext}",
            "{$this->outputPrefix()}/{$parts->name}_{$parts->filter}.{$parts->ext}",
            $parts->filter,
            "{$this->urlPrefix()}/{$parts->name}_{$parts->filter}.{$parts->ext}"
        );
    }

    /**
     * Creates formula
     *
     * @param string $url
     * @return Formula|null
     */
    public function forUrl($url)
    {
        $parts = $this->match(['url_prefix', 'name', 'filter', 'ext'], $url);

        if (!$parts) {
            return null;
        }

        return new Formula(
            "{$this->inputPrefix()}/{$parts->name}.{$parts->ext}",
            "{$this->outputPrefix()}/{$parts->name}_{$parts->filter}.{$parts->ext}",
            $parts->filter,
            "{$this->urlPrefix()}/{$parts->name}_{$parts->filter}.{$parts->ext}"
        );
    }

    protected function match(array $patterns, $subject)
    {
        $pattern2regexp = [
            'input_prefix' => "(?<input_prefix>" . preg_quote($this->inputPrefix(), '/') . ")\/",
            'output_prefix' => "(?<output_prefix>" . preg_quote($this->outputPrefix(), '/') . ")\/",
            'url_prefix' => "(?<url_prefix>" . preg_quote($this->urlPrefix(), '/') . ")\/",
            'name' => "(?<name>.*)",
            'filter' => "_(?<filter>[a-z][a-z0-9]*)",
            'filter_name' => "(?<filter>[a-z][a-z0-9]*)",
            'ext' => "\.(?<ext>[a-zA-Z]+)",
        ];

        $parts = [];
        preg_match(
            collect($patterns)
                ->map(function ($pattern) use ($pattern2regexp) {
                    return $pattern2regexp[$pattern];
                })
                ->prepend("/^")
                ->push("$/")
                ->join('')
            ,
            $subject,
            $parts
        );
        if (!$parts) {
            return null;
        }
        $parts = (object)$parts;

        return $parts;
    }

    protected function inputPrefix()
    {
        return 'app/img';
    }

    protected function outputPrefix()
    {
        return 'app/cache/img';
    }

    protected function urlPrefix()
    {
        return 'storage-img';
    }

}

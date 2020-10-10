<?php

namespace App\Media\Modify;

/**
 * Formula Matcher
 *
 * Defines formula validation - storage prefix path characters for filter, etc
 * Used by FormulaBy<...>Factory
 */
class FormulaMatcher
{

    const INPUT_PREFIX = 'INPUT_PREFIX';
    const OUTPUT_PREFIX = 'OUTPUT_PREFIX';
    const URL_PREFIX = 'URL_PREFIX';
    const MAIN = 'MAIN';
    const FILTER = 'FILTER';
    const EXT = 'EXT';

    protected $matched = [];

    /**
     * Match
     *
     * @param string $subject
     * @param array $patterns
     * @return static|nul
     */
    public static function invoke($subject, $patterns)
    {
        return (new static)->__invoke($subject, $patterns);
    }

    public function inputPrefix()
    {
        return 'app/img';
    }

    public function outputPrefix()
    {
        return 'app/cache/img';
    }

    public function urlPrefix()
    {
        return 'storage-img';
    }

    public function main()
    {
        return $this->matched[self::MAIN];
    }

    public function filter()
    {
        return $this->matched[self::FILTER];
    }

    public function ext()
    {
        return $this->matched[self::EXT];
    }

    /**
     * Match
     *
     * @param string $subject
     * @param array $patterns
     * @return static|nul
     */
    public function __invoke($subject, $patterns)
    {
        $this->matched = [];

        preg_match($this->pattern($patterns), $subject, $this->matched);

        if (!$this->matched) {
            return null;
        }

        return $this;
    }

    protected function regexp($pattern)
    {
        switch ($pattern) {
            case self::INPUT_PREFIX:
                return "(?<" . self::INPUT_PREFIX .">" . preg_quote($this->inputPrefix(), '/') . ")\/";
            case self::OUTPUT_PREFIX:
                return "(?<" . self::OUTPUT_PREFIX . ">" . preg_quote($this->outputPrefix(), '/') . ")\/";
            case self::URL_PREFIX:
                return "(?<" . self::URL_PREFIX . ">" . preg_quote($this->urlPrefix(), '/') . ")\/";
            case self::MAIN:
                return "(?<" . self::MAIN . ">.*)";
            case self::FILTER:
                return "_(?<" . self::FILTER . ">[a-z][a-z0-9]*)";
            case self::EXT:
                return "\.(?<" . self::EXT . ">[a-zA-Z]+)";
        }
    }

    protected function pattern($patterns)
    {
        return collect($patterns)
            ->map(function ($pattern) {
                return $this->regexp($pattern);
            })
            ->prepend("/^")
            ->push("$/")
            ->join('')
        ;
    }

}

<?php

namespace App\Media\Modify;

class Formula
{

    protected $input;
    protected $output;
    protected $filter;
    protected $url;

    public function __construct($input, $output, $filter, $url)
    {
        $this->input = $input;
        $this->output = $output;
        $this->filter = $filter;
        $this->url = $url;
    }

    /**
     * Input path
     *
     * @return string eg. "app/img/article/a/b/c/d/test.jpg"
     */
    public function input()
    {
        return $this->input;
    }

    /**
     * Output path with filter name
     *
     * @return string eg. "app/cache/img/article/a/b/c/d/test_s.jpg"
     */
    public function output()
    {
        return $this->output;
    }

    /**
     * Filter name
     *
     * @return string eg. "s"
     */
    public function filter()
    {
        return $this->filter;
    }

    /**
     * Public url with filter name
     *
     * @return string eg. "/storage/img/article/a/b/c/d/test_s.jpg"
     */
    public function url()
    {
        return $this->url;
    }

}

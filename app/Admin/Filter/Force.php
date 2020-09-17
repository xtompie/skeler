<?php

namespace App\Admin\Filter;

class Force extends Filter
{

    public function type()
    {
        return 'force';
    }

    public function apply()
    {
    }

    public function vm()
    {
        return null;
    }

    public function valueDefault()
    {
        return true;
    }

}

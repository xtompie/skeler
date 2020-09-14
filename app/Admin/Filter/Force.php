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
        $this->query()->where('title', "=", 'aa');
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

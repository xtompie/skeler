<?php

namespace App\Admin\Filter;

class ID extends Filter
{

    public function type()
    {
        return 'id';
    }

    public function apply()
    {
        $this->query()->where($this->name(), "=", "{$this->value()}");
    }

    public function nameDefault()
    {
        return 'id';
    }

    public function labelDefault()
    {
        return 'ID...';
    }

}

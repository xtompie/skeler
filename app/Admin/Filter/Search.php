<?php

namespace App\Admin\Filter;

class Search extends Filter
{

    protected $field;

    public function type()
    {
        return 'search';
    }

    public function apply()
    {
        $this->query()->where($this->field(), "LIKE", "%{$this->value()}%");
    }

    public function labelDefault()
    {
        return 'Search...';
    }

    public function field($field = null)
    {
        if (func_num_args() === 0) {
            return $this->field ?: $this->name();
        }
        $this->field = $field;
        return $this;
    }

}

<?php

namespace App\Admin\Filter;

class Select extends Filter
{

    protected $field;
    protected $options;

    public function type()
    {
        return 'select';
    }

    public function apply()
    {
        $this->query()->where($this->field(), "=", $this->value());
    }

    public function options($options = null)
    {
        if (func_num_args() === 0) {
            return $this->options ?: $this->optionsDefault();
        }
        $this->options = $options;
        return $this;
    }

    public function optionsDefault()
    {
        /**
         * @TODO
         * if $this->name() filed exists in Builder $this->query()
         * create new clean builder
         * fetch distinc values order by COUNT(*) DESC
         * limit 100
         * sort A-Z in php
         * create array where key is that $value and array value is "{ucfirst($value)} ({$count})"
         */
        return [];
    }

    public function field($field = null)
    {
        if (func_num_args() === 0) {
            return $this->field ?: $this->name();
        }
        $this->field = $field;
        return $this;
    }

    public function vm() {
        return collect(parent::vm())->merge([
            'options' => $this->options(),
        ]);
    }

}


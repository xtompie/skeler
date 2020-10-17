<?php

namespace App\Admin\Field;

class Info extends Field
{

    protected $escape;

    public function type()
    {
        return 'info';
    }

    public function enableDefault()
    {
        return ['list', 'detail'];
    }

    /**
     * @param bool $escape
     * @return static
     */
    public function escape($escape = null)
    {
        if (func_num_args() === 0) {
            return $this->escape ?: true;
        }
        $this->escape = $escape;
        return $this;
    }

    public function vm()
    {
        return collect(parent::vm())->merge([
            'escape' => $this->escape(),
        ])->toArray();
    }

    public function store()
    {
        return;
    }

}

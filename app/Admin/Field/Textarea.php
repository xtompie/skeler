<?php

namespace App\Admin\Field;

class Textarea extends Field
{

    protected $cols;
    protected $rows;

    public function type()
    {
        return 'textarea';
    }

     /**
     * @param string $cols
     * @return static
     */
    public function cols($cols)
    {
        $this->cols = $cols;
        return $this;
    }

    /**
     * @param string $cols
     * @return static
     */
    public function rows($rows)
    {
        $this->rows = $rows;
        return $this;
    }

    public function vm()
    {
        return collect(parent::vm())->merge([
            'cols' => $this->cols,
            'rows' => $this->rows,
        ])->toArray();
    }

}

<?php

namespace App\Admin\Field;

class Textarea extends Field
{

    protected $type = 'textarea';
    protected $cols;
    protected $rows;

    /**
     * @param string $cols
     * @return self
     */
    public function cols($cols)
    {
        $this->cols = $cols;
        return $this;
    }

    /**
     * @param string $cols
     * @return self
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

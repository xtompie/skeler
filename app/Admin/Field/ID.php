<?php

namespace App\Admin\Field;

class ID extends Field
{

    protected $type = 'id';
    protected $name = 'id';
    protected $label = 'ID';
    protected $showOn = 'index|detail';


    public function value2model($value)
    {
        // id can't be overrided
        return;
    }


}

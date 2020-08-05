<?php

namespace App\Admin\Field;

class Field
{

    protected $type;


    public static function make($type = null)
    {
        return new self($type);
    }

    public function type($type = null)
    {
        if (func_num_args() == 0) {
            return $this->type;
        }
        $this->type = $type;
        return $this;
    }

}


/**
 * type
 * name
 * label
 * sortable
 * readonly
 * required
 * rules
 * rulesForCreate
 * rulesForUpdate
 * view
 *
 * post, entity, form
 * post2form, entity2form, form2entity // bo validacja form
 *
 * request model view
 * request == view
 * request2model
 * model2request


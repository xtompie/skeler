<?php

namespace App\Admin\Field;

class ID extends Field
{

    public function type()
    {
        return 'id';
    }

    public function enableDefault()
    {
        return ['index', 'detail'];
    }

    public function nameDefault()
    {
        return 'id';
    }

    public function labelDefault()
    {
        return 'ID';
    }

    public function store()
    {
        return;
    }


}

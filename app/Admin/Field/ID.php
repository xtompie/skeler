<?php

namespace App\Admin\Field;

class ID extends Field
{

    protected $type = 'id';
    protected $name = 'id';
    protected $label = 'ID';
    protected $showOnIndex = true;
    protected $showOnCreate = true;
    protected $showOnDetail = true;
    protected $showOnUpdate = true;

}

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
        return ['list', 'detail'];
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

    public function sortableDefault()
    {
        return true;
    }

    public function sortAutoDefault()
    {
        return true;
    }

    public function sortDirDefault()
    {
        return 'desc';
    }


}

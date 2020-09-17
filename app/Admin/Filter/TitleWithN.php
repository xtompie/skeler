<?php

namespace App\Admin\Filter;

class TitleWithN extends Force
{

    public function apply()
    {
        $this->query()->where('title', 'LIKE', '%n%');
    }

}

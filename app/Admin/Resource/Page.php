<?php

namespace App\Admin\Resource;

use App\Admin\Field\ID;
use App\Admin\Field\Text;

class Page extends Resource
{

    public function fields()
    {
        return [
            ID::make(),
            Text::make()->name('title')->label('Title'),
        ];
    }

}

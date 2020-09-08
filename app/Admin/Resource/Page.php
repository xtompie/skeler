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
            Text::make()->name('title')->label('Title')->rules('min:2')
                // ->showUsing(function(ID $field) {
                //     return $field->model()->type == 'some value';
                // })
                // ->showOn('index|detail')
                // ->showOn(['index', 'detail'])
                ,
        ];
    }

}

<?php

namespace App\Admin\Resource;

use App\Admin\Field\ID;
use App\Admin\Field\Text;
use App\Admin\Field\Textarea;

class Page extends Resource
{

    public function fields()
    {
        return [
            ID::make(),
            Text::make()->name('title')->label('Title')->rules('min:2'),
            Text::make()->name('subtitle')->label('Subtitle')->showOn('detail|create|update'),
            Textarea::make()->name('body')->label('Body')->showOn('detail|create|update')->rows(10),
        ];
    }

}

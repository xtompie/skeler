<?php

namespace App\Admin\Resource;

use App\Admin\Field\File;
use App\Admin\Field\ID;
use App\Admin\Field\Info;
use App\Admin\Field\Text;
use App\Admin\Field\Textarea;
use App\Admin\Filter\TitleWithN;
use App\Admin\Filter\ID as FilterID;
use App\Admin\Filter\Search;
use App\Admin\Filter\Select;
use Illuminate\Support\Arr;

class Page extends Resource
{

    public function fields()
    {
        return [
            ID::make(),
            Text::make()->name('title')->label('Title')->rules('min:2')->enableOnList()->sortable(true),
            Info::make()->label('Info')->loadUsing(function(Info $field) {
                return strtoupper(substr($field->model()->title, 0, 10));
            }),
            Text::make()->name('subtitle')->label('Subtitle'),
            Textarea::make()->name('body')->label('Body')->disableOnDetail()->rows(10),
            // File::make()->name('file')->label('File'),
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        if ($this->id() && !$this->isContext('delete')) {
            $actions[] = $this->actionDummy();
        }
        return $actions;
    }

    public function resourceNew()
    {
        if ($this->request()->has('dummy')) {
            return $this->withNewModel()->withValue($this->request()->get('dummy'));
        }

        return parent::resourceNew();
    }

    protected function actionDummy()
    {
        return [
            'name' => 'dummy',
            'url' => route("admin.resource.{$this->name()}.create") . '?' . Arr::query(['dummy' => $this->actionDummyValue()]),
        ];
    }

    protected function actionDummyValue()
    {
        return [
            'title' => 'XD',
        ];
    }

    public function filters()
    {
        return [
            FilterID::make(),
            Search::make()->name('title'),
            Select::make()->name('title_first_letter')->field('title')->label('Title...')->options([
                'aa' => 'Title: aa',
                'bb' => 'Title: bb',
            ]),
            // TitleWithN::make(),
        ];
    }

}

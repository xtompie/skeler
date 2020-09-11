<?php

namespace App\Admin\Resource;

use App\Admin\Field\ID;
use App\Admin\Field\Text;
use Illuminate\Support\Arr;
use App\Admin\Field\Textarea;

class Page extends Resource
{

    public function fields()
    {
        return [
            ID::make(),
            Text::make()->name('title')->label('Title')->rules('min:2')->enableOnIndex(),
            Text::make()->name('subtitle')->label('Subtitle'),
            Textarea::make()->name('body')->label('Body')->hideOnDetail()->rows(10),
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

}

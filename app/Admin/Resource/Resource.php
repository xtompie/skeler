<?php

namespace App\Admin\Resource;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Resource
{

    public function key()
    {
        return Str::snake(Str::pluralStudly(class_basename($this)));
    }

    public function modelClass()
    {
        return null;
    }

    public function routeRegisters()
    {
        Route::group([
            'prefix' => 'resource/' . $this->key(),
        ], function () {
            Route::get('index', $this->controllerIndex()); /** @TOOD defaults resource => $this->key() */
            /** @TODO create, detail, update, delete */
        });
    }

    public function controllerIndex()
    {
        return \Module\Admin\Http\Controller\Resource\IndexControler::class;
    }

    public function fields()
    {
        // return [
        //     Field::make()->sortable(),
        //     Text::make('Name')->sortable(),
        // ];
    }

    public function fieldsForIndex()
    {

    }



}

/*

public function controllerCreate()
{
    return \Module\Admin\Http\Controller\Resource\CreateController::class;
}

public function controllerDetail()
{
    return \Module\Admin\Http\Controller\Resource\CreateController::class;
}

public function controllerUpdate()
{
    return \Module\Admin\Http\Controller\Resource\UpdateController::class;
}

public function controllerDelete()
{
    return \Module\Admin\Http\Controller\Resource\DeleteController::class;
}

public function redirectAfterCreate()
{

}

public function redirectAfterUpdate()
{

}

public function redirectAfterDelete()
{

}








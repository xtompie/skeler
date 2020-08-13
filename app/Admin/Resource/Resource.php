<?php

namespace App\Admin\Resource;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Resource
{

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @param Request $request
     * @return self
     */
    public function withRequest(Request $request)
    {
        $resource = clone $this;
        $resource->request = $request;
        return $resource;
    }

    public function key()
    {
        return Str::snake(class_basename($this));
    }

    public function model()
    {
        return "App\\Model\\" + class_basename($this);
    }

    public function routeRegister()
    {
        Route::group([
            'prefix' => 'resource/' . $this->key(),
            'resource' => $this->key(),
        ], function () {
            Route::get('', $this->controllerIndex());
        });
    }

    public function controllerIndex()
    {
        return \App\Admin\Http\Controller\Resource\IndexController::class;
    }

    public function aclIndex()
    {

    }

    public function viewIndex()
    {

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

    public function getResourcesForIndex()
    {
        return collect();
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



*/




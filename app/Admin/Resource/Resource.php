<?php

namespace App\Admin\Resource;

use Illuminate\Database\Eloquent\Model;
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
     * @var Model $model
     */
    protected $model;

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

    public function withModel(Model $model)
    {
        $resource = clone $this;
        $resource->model = $model;
        return $resource;
    }

    public function key()
    {
        return Str::snake(class_basename($this));
    }

    public function modelClass()
    {
        return "App\\Model\\" . class_basename($this);
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
        return 'admin.resource.resource.index';
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
        $query = $this->query();

        $resources = $query->paginate(20)->map(function ($i) {
            return $this->withModel($i);
        });

        dd($resources);

        return $resources;
    }

    public function getDataForIndex()
    {

    }

    protected function query()
    {
        return call_user_func([$this->modelClass(), 'query']);
    }

}

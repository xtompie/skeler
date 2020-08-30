<?php

namespace App\Admin\Resource;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use \ReflectionClass;

class Resource
{

    public static function resources()
    {
        return collect(config('admin.resources'))
            ->mapWithKeys(function($i) {
                $resource = (new ReflectionClass($i))->newInstance();
                return [$resource->name() => $resource];
            })
        ;
    }

    public static function resource($name)
    {
        return self::resources()[$name];
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \App\Admin\Resource\Resource
     */
    public static function resourceByRequest($request)
    {
        $resource = self::resource($request->route()->getAction()['resource']);
        return $resource ? $resource->withRequest($request) : null;
    }

    public static function each()
    {
        return self::resources()->each;
    }

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

    public function name()
    {
        return Str::snake(class_basename($this));
    }

    public function modelClass()
    {
        return "App\\Model\\" . class_basename($this);
    }

    public function model()
    {
        return $this->model;
    }

    public function routeRegister()
    {
        Route::group([
            'prefix' => 'resource/' . $this->name(),
            'resource' => $this->name(),
        ], function () {
            $this->routeRegisterForIndex();
            $this->routeRegisterForDetail();
            $this->routeRegisterForCreate();
            $this->routeRegisterForUpdate();
            $this->routeRegisterForDelete();
        });
    }

    public function routeRegisterForIndex()
    {
        Route::get('index', [
            'context' => 'index',
            'uses' => $this->controllerForIndex(),
        ]);
    }

    public function routeRegisterForDetail()
    {
        Route::get('detail/{id}', [
            'context' => 'detail',
            'uses' => $this->controllerForDetail(),
        ]);
    }

    public function routeRegisterForCreate()
    {
        Route::get('create', [
            'context' => 'create',
            'uses' => $this->controllerForCreate(),
        ]);
    }

    public function routeRegisterForUpdate()
    {
        Route::get('update/{id}', [
            'context' => 'update',
            'uses' => $this->controllerForUpdate(),
        ]);
    }

    public function routeRegisterForDelete()
    {
        Route::get('delete/{id}', [
            'context' => 'delete',
            'uses' => $this->controllerForDelete(),
        ]);
    }

    public function controllerForIndex()
    {
        return \App\Admin\Http\Controller\Resource\IndexController::class;
    }

    public function controllerForDetail()
    {
        return \App\Admin\Http\Controller\Resource\DetailController::class;
    }

    public function controllerForCreate()
    {
        return \App\Admin\Http\Controller\Resource\CreateController::class;
    }

    public function controllerForUpdate()
    {
        return \App\Admin\Http\Controller\Resource\UpdateController::class;
    }

    public function controllerForDelete()
    {
        return \App\Admin\Http\Controller\Resource\DeleteController::class;
    }

    public function context()
    {
        $this->request->route()->getAction()['context'];
    }

    public function aclForIndex()
    {

    }

    public function aclForDetail()
    {

    }

    public function aclForCreate()
    {

    }

    public function aclForUpdate()
    {

    }

    public function aclForDelete()
    {

    }

    public function id()
    {
        return $this->model->id;
    }


    public function title()
    {
        $attrs = collect($this->model->getAttributes())->keys();
        foreach (['title', 'name', 'id'] as $attr) {
            if ($attrs->contains('title')) {
                return $this->model->$attr;
            }
        }
        return null;
    }

    public function subtitle()
    {
        return null;
    }

    public function avatar()
    {
        return null;
    }

    public function viewForIndex()
    {
        return 'admin.resource.resource.index';
    }

    public function viewForDetail()
    {
        return 'admin.resource.resource.detail';
    }

    public function viewForCreate()
    {
        return 'admin.resource.resource.create';
    }

    public function viewForUpdate()
    {
        return 'admin.resource.resource.update';
    }

    public function viewForDelete()
    {
        return 'admin.resource.resource.delete';
    }

    public function fields()
    {
        return [];
    }

    public function fieldsForIndex()
    {
        return collect($this->fields())
            ->map(function($field) {
                return $field->fieldForIndex();
            })
            ->filter()
        ;
    }

    public function fieldsForDetail()
    {
        return collect($this->fields())
            ->map(function($field) {
                return $field->fieldForDetail();
            })
            ->filter()
        ;
    }

    public function fieldsForCreate()
    {
        return collect($this->fields())
            ->map(function($field) {
                return $field->fieldForCreate();
            })
            ->filter()
        ;
    }

    public function fieldsForUpdate()
    {
        return collect($this->fields())
            ->map(function($field) {
                return $field->fieldForUpdate();
            })
            ->filter()
        ;
    }

    public function resourcesForIndex()
    {
        $query = $this->queryForIndex();

        $models = $query->paginate(20);

        $result = [
            'models' => $models,
            'resources' => $models->map(function($model) {
                return $this->withModel($model);
            }),
        ];

        return $result;
    }

    public function resourceForDetail()
    {
        $query = $this->queryForDetail();

        $model = $query->find($this->request->id);

        if (!$model) {
            return null;
        }

        $resource = $this->withModel($model);

        return $resource;
    }

    public function vmForIndex()
    {
        return collect($this->fieldsForIndex())
            ->map(function($field) {
                return $field->withResource($this)->vm();
            })
        ;
    }

    public function vmForDetail()
    {
        return collect($this->fieldsForDetail())
            ->map(function($field) {
                return $field->withResource($this)->vm();
            })
        ;
    }

    public function queryForIndex()
    {
        return $this->query();
    }

    public function queryForDetail()
    {
        return $this->query();
    }

    public function queryForCreate()
    {
        return $this->query();
    }

    public function queryForUpdate()
    {
        return $this->query();
    }

    public function queryForDelete()
    {
        return $this->query();
    }

    protected function query()
    {
        return call_user_func([$this->modelClass(), 'query']);
    }

}

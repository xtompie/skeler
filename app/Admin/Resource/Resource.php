<?php

namespace App\Admin\Resource;

use App\Admin\Field\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use \ReflectionClass;

class Resource
{

    /* static */

    public static function makeAll()
    {
        return collect(config('admin.resources'))
            ->mapWithKeys(function($i) {
                $resource = (new ReflectionClass($i))->newInstance();
                return [$resource->name() => $resource];
            })
        ;
    }

    public static function make($name)
    {
        return self::makeAll()[$name];
    }

    public static function each()
    {
        return self::makeAll()->each;
    }

    /* instance */

    /**
     * Context index|detail|create|update|delete
     *
     * @var String
     */
    protected $context;
    /**
     * @var Model $model
     */
    protected $model;

    /* mutables */

    public function withContext($context)
    {
        $resource = clone $this;
        $resource->context = $context;
        return $resource;
    }

    public function withModel(Model $model)
    {
        $resource = clone $this;
        $resource->model = $model;
        return $resource;
    }

    /* context */

    public function context()
    {
        return $this->context;
    }

    /* routes */

    public function routeRegister()
    {
        Route::group(
            [
                'prefix' => 'resource/' . $this->name(),
            ],
            function () {
                $this->routeRegisterAll();
            }
        );
    }

    public function routeRegisterAll()
    {
        $this->routeRegisterForIndex();
        $this->routeRegisterForDetail();
        $this->routeRegisterForCreate();
        $this->routeRegisterForUpdate();
        $this->routeRegisterForDelete();
    }

    public function routeRegisterForIndex()
    {
        Route::get('', [
            'resource' => $this->name(),
            'context' => 'index',
            'uses' => \App\Admin\Http\Controller\Resource\Resource\IndexController::class,
        ])->name("admin.resource.{$this->name()}.index");
    }

    public function routeRegisterForDetail()
    {
        Route::get('{id}', [
            'resource' => $this->name(),
            'context' => 'detail',
            'uses' => \App\Admin\Http\Controller\Resource\Resource\DetailController::class,
        ])
            ->where('id', '[0-9]+')
            ->name("admin.resource.{$this->name()}.detail")
        ;
    }

    public function routeRegisterForCreate()
    {
        Route::match(['get', 'post'], 'create', [
            'resource' => $this->name(),
            'context' => 'create',
            'uses' => \App\Admin\Http\Controller\Resource\Resource\CreateController::class,
        ])
            ->name("admin.resource.{$this->name()}.create")
        ;
    }

    public function routeRegisterForUpdate()
    {
        Route::match(['get', 'post'], '/{id}/update', [
            'resource' => $this->name(),
            'context' => 'update',
            'uses' => \App\Admin\Http\Controller\Resource\Resource\UpdateController::class,
        ])
            ->where('id', '[0-9]+')
            ->name("admin.resource.{$this->name()}.update")
        ;
    }

    public function routeRegisterForDelete()
    {
        Route::match(['get', 'post'], '{id}/delete', [
            'resource' => $this->name(),
            'context' => 'delete',
            'uses' => \App\Admin\Http\Controller\Resource\Resource\DeleteController::class,
        ])
            ->where('id', '[0-9]+')
            ->name("admin.resource.{$this->name()}.delete")
        ;
    }

    /* redirect */

    public function redirect()
    {
        if ($this->context() == 'create') {
            return $this->redirectForCreate();
        }
        if ($this->context() == 'update') {
            return $this->redirectForUpdate();
        }
        if ($this->context() == 'delete') {
            return $this->redirectForDelete();
        }
    }

    public function redirectForCreate()
    {
        return redirect()->route("admin.resource.{$this->name()}.update", ['id' => $this->id()]);
    }

    public function redirectForUpdate()
    {
        return redirect()->route("admin.resource.{$this->name()}.update", ['id' => $this->id()]);
    }

    public function redirectForDelete()
    {
        return redirect()->route("admin.resource.{$this->name()}.index");
    }

    /* acl */

    public function acl()
    {

    }

    /* properties */

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

    public function id()
    {
        return optional($this->model)->id;
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

    /**
     * Actions
     *
     * @return void
     */

    public function actions()
    {
        if (!$this->id()) {
            return
                $this->actionIndex()
                + $this->actionCreate()
            ;
        }

        return
            $this->actionIndex()
            + $this->actionDetail()
            + $this->actionUpdate()
            + $this->actionDuplicate()
            + $this->actionDelete()
        ;
    }

    public function actionIndex()
    {
        return ['index' => route("admin.resource.{$this->name()}.index")];
    }

    public function actionCreate()
    {
        return ['create' => route("admin.resource.{$this->name()}.create")];
    }

    public function actionDuplicate()
    {
        return [
            'duplicate' =>
                route("admin.resource.{$this->name()}.create")
                . '?' . Arr::query(['duplicate' => $this->id()])
        ];
    }

    public function actionDetail()
    {
        return ['detail' => route("admin.resource.{$this->name()}.detail", ['id' => $this->id()])];
    }

    public function actionUpdate()
    {
        return ['update' => route("admin.resource.{$this->name()}.update", ['id' => $this->id()])];
    }

    public function actionDelete()
    {
        return ['delete' => route("admin.resource.{$this->name()}.delete", ['id' => $this->id()])];
    }

    /* query */

    protected function query()
    {
        return call_user_func([$this->modelClass(), 'query']);
    }

    public function resourcesByParams($params)
    {
        $query = $this->query();

        $models = $query->paginate(20);

        $result = [
            'models' => $models,
            'resources' => $models->map(function($model) {
                return $this->withModel($model);
            }),
        ];

        return $result;
    }

    public function resourceNew($params)
    {
        $model = (new ReflectionClass($this->modelClass()))->newInstance();
        $resource = $this->withModel($model);
        // if (array_key_exists('duplicate', $params)) {
        //     $duplicate = $resource->resourceById($params['duplicate']);
        //     if ($duplicate) {
        //         $resource = $resource->withValue()
        //     }
        //     $resource = $resource->resourceById()
        // }

        return $resource;

    }

    public function resourceById($id)
    {
        /** create ->withId(), use it here and in resource New in duplicate */
        $model = $this->query()->find($id);
        return $model ? $this->withModel($model) : null;
    }

    /* fields */

    public function fields()
    {
        return [];
    }

    public function resolveFields()
    {
        return collect($this->fields())
            ->filter()
            ->map(function(Field $field) {
                return $field->withResource($this)->resolveField();
            })
            ->filter()
        ;
    }

    /* view */

    public function vm($value = null, $errors = null)
    {
        // no model
        if (!$this->model) {
            return collect([
                'name' => $this->name(),
                'context' => $this->context(),
                'labels' => $this->resolveFields()->map(function(Field $field) {
                    return $field->label();
                }),
                'actions' => $this->actions(),
            ])->toArray();
        }

        // model
        $value = func_num_args() > 0 ? $value : $this->value();
        return collect([
            'id' => $this->id(),
            'title' => $this->title(),
            'name' => $this->name(),
            'context' => $this->context(),
            'fields' => $this->resolveFields()->map(function(Field $field) use ($value, $errors) {
                $field = $field->withResource($this)->withValue($value);
                $field = $errors ? $field->withErrors($errors) : $field;
                return $field->vm();
            })->toArray(),
            'actions' => $this->actions(),
        ])->toArray();
    }

    /* value */

    public function value()
    {
        // dummy
        if ($this->context() == 'create') {
            $value = [];
            $this->resolveFields()->each(function(Field $field) use (&$value) {
                $value = array_merge($value, $field->withDummy()->valuePack());
            });
            return $value;
        }

        // from model
        $value = [];
        $this->resolveFields()->each(function(Field $field) use (&$value) {
            $value = array_merge($value, $field->withLoad()->valuePack());
        });
        return $value;
    }

    /* save */

    public function rules()
    {
        $rules = [];
        $this->resolveFields()->each(function(Field $field) use (&$rules) {
            $rules = array_merge($rules, $field->rulesPack());
        });
        return $rules;
    }

    public function validate($value)
    {
        $validator = validator($value, $this->rules());
        return $validator->fails() ? $validator->errors()->toArray() : null;
    }

    public function store($value)
    {
        $errors = $this->validate($value);
        if ($errors) {
            return $errors;
        }
        $this->resolveFields()->each(function(Field $field) use ($value) {
            $field->withValue($value)->store();
        });
        $this->model->save();
    }

    public function delete()
    {
        $this->model->delete();
    }

}

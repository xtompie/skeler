<?php

namespace App\Admin\Resource;

use App\Admin\Field\Field;
use Illuminate\Database\Eloquent\Model;
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
            $this->redirectForCreate();
        }
        if ($this->context() == 'update') {
            $this->redirectForUpdate();
        }
        if ($this->context() == 'delete') {
            $this->redirectForDelete();
        }
    }

    public function redirectForCreate()
    {
        redirect()->route("admin.resource.{$this->name()}.update", ['id' => $this->id()]);
    }

    public function redirectForUpdate()
    {
        redirect()->route("admin.resource.{$this->name()}.update", ['id' => $this->id()]);
    }

    public function redirectForDelete()
    {
        redirect()->route("admin.resource.{$this->name()}.index");
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
        return $this->withModel(
            (new ReflectionClass($this->modelClass()))->newInstance()
        );
    }

    public function resourceById($id)
    {
        $model = $this->queryForItem()->find($id);
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
            ->map(function(Field $field) {
                return $field->resolveField();
            })
            ->filter()
        ;
    }

    /* view */

    public function vm($value, $errors = null)
    {
        return $this->resolveFields()->map(function(Field $field) use ($value, $errors) {
            $field = $field->withResource($this);
            $value = $field->union2value($value);
            $errors = $errors ? $field->union2errors($errors) : null;
            return $field->vm($value, $errors);
        });
    }

    /* value */

    public function value()
    {
        // dummy
        if ($this->context() == 'create') {
            $value = collect();
            $this->resolveFields()->each(function(Field $field) use ($value) {
                $value->union($field->value2union($field->dummy()));
            });
            return $value->toArray();
        }

        // from model
        $value = collect();
        $this->resolveFields()->each(function(Field $field) use ($value) {
            $value->union($field->value2union($field->model2value()));
        });
        return $value->toArray();
    }

    /* store */

    public function rules()
    {
        $rules = collect();
        $this->resolveFields()->each(function($field) use ($rules) {
            $rules->union($field->rules2union());
        });
        return $rules->toArray();
    }

    public function validate($value)
    {
        $validator = validator($value, $this->rules());
        return $validator->fails() ? $validator->errors() : null;
    }

    public function store($value)
    {
        $errors = $this->validate($value);
        if ($errors) {
            return $errors;
        }

        $this->resolveFields()->each(function(Field $field) use ($value) {
            $field->value2model($field->union2value($value));
        });
        $this->model->save();
    }

}

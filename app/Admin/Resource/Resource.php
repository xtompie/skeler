<?php

namespace App\Admin\Resource;

use \ReflectionClass;
use App\Admin\Field\Field;
use App\Admin\Filter\Filter;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public static function makeWithRequest(Request $request, $context)
    {
        $action = $request->route()->getAction();

        $resource = static::make($action['resource']);
        if (!$resource)  {
            return null;
        }

        $resource = $resource->withRequest($request);

        $resource = $resource->withContext($action['context']);
        if (!$resource->isContext($context)) {
            return null;
        }

        return $resource;
    }

    /* instance */

    /**
     * @var Request
     */
    protected $request;

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

    /** @var mixed */
    protected $value;

    /** @var array */
    protected $errors;

    /** @var array */
    protected $filters;

    /* mutables */

    public function withRequest(Request $request)
    {
        $resource = clone $this;
        $resource->request = $request;
        return $resource;
    }

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

    public function withNewModel()
    {
        return $this->withModel(
            (new ReflectionClass($this->modelClass()))->newInstance()
        );
    }

    public function withValue($value)
    {
        $resource = clone $this;
        $resource->value = $value;
        return $resource;
    }

    public function withRequestValue()
    {
        return $this->withValue($this->request()->all());
    }

    public function withDummy()
    {
        $resource = clone $this;
        $resource->value = $this->dummy();
        return $resource;
    }

    public function withLoad()
    {
        $resource = clone $this;
        $resource->value = $this->load();
        return $resource;
    }

    public function withErrors($errors)
    {
        $resource = clone $this;
        $resource->errors = $errors;
        return $resource;
    }

    public function withId($id)
    {
        $model = $this->queryForItem()->find($id);
        return $model ? $this->withModel($model)->withLoad() : null;
    }

    /*  */

    public function context()
    {
        return $this->context;
    }

    public function isContext($context)
    {
        return in_array($this->context(), is_array($context) ? $context : [$context]);
    }

    public function request()
    {
        return $this->request;
    }

    public function hasModel()
    {
        return (bool)$this->model;
    }

    public function hasId()
    {
        return (bool)$this->id();
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
        $attrs = collect($this->model()->getAttributes())->keys();
        foreach (['title', 'name', 'id'] as $attr) {
            if ($attrs->contains('title')) {
                return $this->model()->$attr;
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

    /* actions */

    public function actions()
    {
        if ($this->isContext('index') && !$this->hasId()) {
            return [
                $this->actionCreate(),
            ];
        }

        if ($this->hasId() && !$this->isContext('delete')) {
            return [
                $this->actionDetail(),
                $this->actionUpdate(),
                $this->actionDuplicate(),
                $this->actionDelete(),
            ];
        }
    }

    public function actionIndex()
    {
        return [
            'name' => 'index',
            'url' => route("admin.resource.{$this->name()}.index"),
        ];
    }

    public function actionCreate()
    {
        return [
            'name' => 'create',
            'url' => route("admin.resource.{$this->name()}.create"),
        ];
    }

    public function actionDuplicate()
    {
        return [
            'name' => 'duplicate',
            'url' => route("admin.resource.{$this->name()}.create") . '?' . Arr::query(['duplicate' => $this->id()]),
        ];
    }

    public function actionDetail()
    {
        return [
            'name' => 'detail',
            'url' => route("admin.resource.{$this->name()}.detail", ['id' => $this->id()]),
        ];
    }

    public function actionUpdate()
    {
        return [
            'name' =>'update',
            'url' => route("admin.resource.{$this->name()}.update", ['id' => $this->id()]),
        ];
    }

    public function actionDelete()
    {
        return [
            'name' => 'delete',
            'url' => route("admin.resource.{$this->name()}.delete", ['id' => $this->id()]),
        ];
    }

    /* query */

    /**
     * @return Builder
     */
    protected function query()
    {
        return call_user_func([$this->modelClass(), 'query']);
    }

    protected function queryForItem()
    {
        return $this->query();
    }

    protected function queryForList()
    {
        $query = $this->query();

        $this->applyFilters($query);

        return $query;
    }


    public function resourcesByParams()
    {
        $query = $this->queryForList();

        $models = $query->paginate(20);

        $result = [
            'models' => $models,
            'resources' => $models->map(function($model) {
                return $this->withModel($model)->withLoad();
            }),
        ];

        return $result;
    }

    public function resourceNew()
    {
        $resource = $this->withNewModel();

        if ($this->request()->has('duplicate')) {
            $duplicate = $resource->withContext('update')->withId($this->request()->get('duplicate'));
            if ($duplicate) {
                return  $resource->withValue($duplicate->value());
            }
        }

        return $resource->withDummy();
    }

    public function resourceById($id)
    {
        return $this->withId($id);
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

    /* filters */

    public function filters()
    {
        return [];
    }

    public function applyFilters(Builder $query)
    {
        $this->filters = collect($this->filters())->map(function(Filter $filter) use ($query) {
            return $filter->withResource($this)->withQuery($query)->runApply();
        })->toArray();
    }

    public function resolveFiltersVm()
    {
        return collect($this->filters?:[])
            ->map(function(Filter $filter) {
                return $filter->vm();
            })
            ->toArray()
        ;
    }


    /* view */

    public function vm()
    {
        $main = [
            'name' => $this->name(),
            'context' => $this->context(),
            'actions' => $this->actions(),
            'breadcrumb' => $this->breadcrumb(),
        ];

        if (!$this->hasModel()) {
            return $main + [
                'labels' => $this->resolveFields()->map(function(Field $field) {
                    return $field->label();
                }),
                'filters' => $this->resolveFiltersVm(),
            ];
        }

        return $main + [
            'id' => $this->id(),
            'title' => $this->title(),
            'fields' => $this->resolveFields()->map(function(Field $field) {
                return $field
                    ->withResource($this)
                    ->withValue($this->value())
                    ->withErrors($this->errors())
                    ->vm();
            }),
        ];
    }

    public function breadcrumb()
    {
        $breadcrumb = [];
        $breadcrumb[] = [
            'title' => 'Admin',
            'url' => '/admin',
        ];
        $breadcrumb[] = [
            'title' => ucfirst($this->name()),
            'url' => route("admin.resource.{$this->name()}.index"),
            'active' => $this->isContext('index'),
        ];
        if ($this->isContext('create')) {
            $breadcrumb[] = [
                'title' => 'Create',
                'url' => route("admin.resource.{$this->name()}.create"),
                'active' => true,
            ];
        }
        if ($this->isContext(['detail', 'update', 'delete'])) {
            $breadcrumb[] = [
                'title' => "#{$this->id()} {$this->title()}",
                'url' => route("admin.resource.{$this->name()}.detail", ['id' => $this->id()]),
                'active' => $this->isContext('detail'),
            ];
        }
        if ($this->isContext(['update', 'delete'])) {
            $breadcrumb[] = [
                'title' => ucfirst($this->context()),
                'url' => route("admin.resource.{$this->name()}.{$this->context()}", ['id' => $this->id()]),
                'active' => true,
            ];
        }
        return $breadcrumb;
    }

    /* value */

    public function value()
    {
        return $this->value;
    }

    protected function dummy()
    {
        $value = [];
        $this->resolveFields()->each(function(Field $field) use (&$value) {
            $value = array_merge($value, $field->withDummy()->valuePack());
        });
        return $value;
    }

    public function errors()
    {
        return $this->errors;
    }

    protected function load()
    {
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

    public function validate()
    {
        $validator = validator($this->value(), $this->rules());
        $errors = $validator->fails() ? $validator->errors()->toArray() : null;
        return $this->withErrors($errors);
    }

    public function store()
    {
        $resource = $this->validate();
        if ($resource->errors()) {
            return $resource;
        }
        $this->resolveFields()->each(function(Field $field) {
            $field->withValue($this->value())->store();
        });
        $this->model()->save();
        return $resource;
    }

    public function delete()
    {
        $resource = $this->validate();
        if ($resource->errors()) {
            return $resource;
        }
        $this->resolveFields()->each(function(Field $field) {
            $field->withValue($this->value())->delete();
        });
        $this->model()->delete();
        return $resource;
    }

}

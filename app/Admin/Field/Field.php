<?php

namespace App\Admin\Field;

use App\Admin\Resource\Resource;
use Illuminate\Database\Eloquent\Builder;

class Field
{

    /* static */

    /**
     * @return static
     */
    public static function make()
    {
        return new static();
    }

    /**
     * @var App\Admin\Resource\Resource $resource
     */
    protected $resource;
    protected $value;
    protected $errors;
    protected $name;
    protected $label;
    protected $view;
    protected $dummy;
    protected $loadUsing;
    protected $storeUsing;
    protected $showUsing;
    protected $enableOn;
    protected $rules;
    protected $sortable;
    protected $sortableFallback;
    protected $sortableDirection;
    protected $sortableSort;

    /* mutables */

    /**
     * @param Resource $resource
     * @return static
     */
    public function withResource(Resource $resource)
    {
        $field = clone $this;
        $field->resource = $resource;
        return $field;
    }

    public function withValue($value)
    {
        $field = clone $this;
        $field->value = $this->unpack($value);
        return $field;
    }

    public function withDummy()
    {
        $field = clone $this;
        $field->value = $this->resolveDummy();
        return $field;
    }

    public function withLoad()
    {
        $field = clone $this;
        $field->value = $this->load();
        return $field;
    }

    public function withErrors($errors)
    {
        $field = clone $this;
        $field->errors = $this->unpack($errors);
        return $field;
    }

    /* properties */

    public function resource()
    {
        return $this->resource;
    }

    public function model()
    {
        return $this->resource()->model();
    }

    public function context()
    {
        return $this->resource()->context();
    }

    /**
     * @param String $type
     * @return static
     */
    public function type()
    {
        throw new \LogicException('Field type not defined');
    }

    /**
     * @param String $type
     * @return static
     */
    public function name($name = null)
    {
        if (func_num_args() == 0) {
            return $this->name ?: $this->nameDefault();
        }
        $this->name = $name;
        return $this;
    }

    public function nameDefault()
    {
        return null;
    }

    /**
     * @param String $type
     * @return static
     */
    public function label($label = null)
    {
        if (func_num_args() == 0) {
            return $this->label ?: $this->labelDefault();
        }
        $this->label = $label;
        return $this;
    }

    public function labelDefault()
    {
        return $this->type();
    }

    /**
     * @param String|\Closure $type
     * @return static
     */
    public function enableOn($contexts = [])
    {
        if (func_num_args() == 0) {
            return $this->enableOn ?: $this->enableDefault();
        }
        $this->enableOn = is_string($contexts) ? explode('|', $contexts) : $contexts;
        return $this;
    }

    public function enableOnIndex()
    {
        $this->enableOn(collect($this->enableOn())->add('index')->unique()->toArray());
        return $this;
    }

    public function disableOnDetail()
    {
        $this->enableOn(collect($this->enableOn)->reject(function($i) { return $i == 'detail'; })->toArray());
        return $this;
    }

    public function enableDefault()
    {
        return ['detail', 'create', 'update'];
    }

    public function resolveField()
    {
        if ($this->enableOn() instanceof \Closure) {
            return call_user_func($this->enableOn(), $this) ? clone $this : null;
        }

        return in_array($this->context(), (array)$this->enableOn()) ? clone $this : null;
    }

    /* view */

    public function view($view = null)
    {
        if (func_num_args() == 0) {
            return $this->view !== null ? $this->view : "admin.field." . $this->type();
        }
        $this->view = $view;
        return $this;
    }

    public function vm()
    {
        return [
            'context' => $this->context(),
            'view' => $this->view(),
            'type' => $this->type(),
            'name' => $this->name(),
            'label' => $this->label(),
            'value' => $this->value(),
            'errors' => $this->errors(),
        ];
    }

    /* value */

    protected function value()
    {
        return $this->value;
    }

    public function dummyDefault()
    {
        return null;
    }

    public function dummy($dummy = null)
    {
        if (func_num_args() === 0) {
            return $this->dummy;
        }

        $this->dummy = $dummy;
        return null;
    }

    public function resolveDummy()
    {
        $dummy = $this->dummy() ?: $this->dummyDefault();

        if ($dummy instanceof \Closure) {
            $dummy = call_user_func($dummy, $this);
        }

        return $dummy;
    }

    public function loadUsing($callback)
    {
        $this->loadUsing = $callback;
        return $this;
    }

    public function load()
    {
        if ($this->loadUsing) {
            return call_user_func($this->loadUsing, $this);
        }
        return $this->model()->{$this->name()};
    }


    public function storeUsing($callback)
    {
        $this->storeUsing = $callback;
        return $this;
    }

    public function store()
    {
        if ($this->storeUsing) {
            call_user_func($this->storeUsing, $this);
            return;
        }
        $this->model()->{$this->name()} = $this->value();
    }

    public function delete()
    {

    }

    /* sort */

    public function sortable($sortable = null)
    {
        if (func_num_args() === 0) {
            return $this->sortable ?: $this->sortableDefault();
        }

        $this->sortable = $sortable;
        return $this;
    }

    public function sortableDefault()
    {
        return false;
    }

    public function sortableFallback($sortableFallback = null)
    {
        if (func_num_args() === 0) {
            return $this->sortableFallback ?: $this->sortableFallbackDefault();
        }

        $this->sortableFallback = $sortableFallback;
        return $this;
    }

    public function sortableFallbackDefault()
    {
        return false;
    }

    public function sortableDirection($sortableDirection = null)
    {
        if (func_num_args() === 0) {
            return $this->sortableDirection ?: $this->sortableDirectionDefault();
        }

        $this->sortableDirection = $sortableDirection;
        return $this;
    }

    public function sortableDirectionDefault()
    {
        return 'desc';
    }

    protected function sortableSort($sort = null)
    {
        if (func_num_args() == 0) {
            return $this->sortableSort;
        }
        $this->sortableSort = $sort;
        return $this;
    }

    protected function sortableApplySortToQuery(Builder $query)
    {
        if ($this->sortableSort() === 'asc') {
            $query->orderBy($this->name());
        }
        else if ($this->sortableSort() === 'desc') {
            $query->orderByDesc($this->name());
        }
    }

    public function sortableFallbackApply(Builder $query)
    {
        $this->sortableSort($this->sortableDirection());
        $this->sortableApplySortToQuery($query);
    }

    public function sortableApply(Builder $query, $value)
    {
        $supported = [
            $this->name() . '-asc' => 'asc',
            $this->name() . '-desc' => 'desc',
        ];

        $this->sortableSort(array_key_exists($value, $supported) ? $supported[$value] : null);

        $this->sortableApplySortToQuery($query);

        return $this->sortableSort() !== null;
    }

    public function sortableVm()
    {
        if (!$this->sortable()) {
            return null;
        }

        // next value
        $next = null;
        if ($this->sortableSort() === null) {
            $next = $this->sortableDirection();
        }
        if ($this->sortableSort() === 'asc') {
            $next = 'desc';
        }
        if ($this->sortableSort() === 'desc') {
            $next = 'asc';
        }
        $next = "{$this->name()}-$next";

        return [
            'direction' => $this->sortableSort(),
            'url' => $this->resource()->sortableUrl($next),
        ];
    }

    public function valuePack()
    {
        return $this->pack($this->value());
    }

    /* error */

    protected function errors()
    {
        return $this->errors;
    }

    /* rules */

    public function rules($rules = null)
    {
        if (func_num_args() == 0) {
            return $this->rules;
        }
        $this->rules = $rules;
        return $this;
    }

    public function resolveRules()
    {
        if ($this->rules instanceof \Closure) {
            return call_user_func($this->rules, $this);
        }
        return $this->rules;
    }

    public function rulesPack()
    {
        return $this->pack($this->resolveRules());
    }

    /* pack */

    public function pack($subject)
    {
        return $subject === null? [] : [$this->name() => $subject];
    }

    public function unpack($struct)
    {
        return $struct[$this->name()] ?? null;
    }

}

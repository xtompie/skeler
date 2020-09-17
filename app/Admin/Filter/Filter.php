<?php

namespace App\Admin\Filter;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Admin\Resource\Resource;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
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
    protected $query;
    protected $value;
    protected $view;
    protected $label;
    protected $name;

    /* mutables */

    /**
     * @param Resource $resource
     * @return static
     */
    public function withResource(Resource $resource)
    {
        $filter = clone $this;
        $filter->resource = $resource;
        return $filter;
    }

    /**
     * @param Builder $query
     * @return static
     */
    public function withQuery(Builder $query)
    {
        $filter = clone $this;
        $filter->query = $query;
        return $filter;
    }

    /* properties */

    public function resource()
    {
        return $this->resource;
    }

    /**
     * @return Request
     */
    public function request()
    {
        return $this->resource()->request();
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->query;
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


    public function value($value = null)
    {
        if (func_num_args() === 0) {
            return $this->value
                ?: $this->valueFromRequest()
                ?: $this->valueDefault()
           ;
        }

        $this->value = $value;
        return $this;
    }

    public function valueDefault()
    {
        return null;
    }

    public function valueFromRequest()
    {
        return Arr::get($this->request()->query(), "filter.{$this->name()}");
    }

    public function url($value = null)
    {
        $query = $this->request()->query();
        Arr::set($query, "filter.{$this->name()}", $value);
        return $this->request()->url() . '?' . Arr::query($query);
    }

    public function reset()
    {
        $query = $this->request()->query();
        Arr::forget($query, "filter.{$this->name()}");
        Arr::forget($query, "page");
        return $this->request()->url() . '?' . Arr::query($query);
    }

    /* view */

    public function view($view = null)
    {
        if (func_num_args() == 0) {
            return $this->view ?: "admin.filter." . $this->type();
        }
        $this->view = $view;
        return $this;
    }

    public function vm()
    {
        return [
            'view' => $this->view(),
            'type' => $this->type(),
            'name' => $this->name(),
            'label' => $this->label(),
            'value' => $this->value(),
            'reset' => $this->reset(),
        ];
    }

    /* filter */

    public function runApply()
    {
        if ($this->value()) {
            $this->apply();
        }
        return $this;
    }

    public function apply()
    {

    }
}

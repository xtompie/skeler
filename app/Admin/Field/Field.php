<?php

namespace App\Admin\Field;

use App\Admin\Resource\Resource;
use Illuminate\Support\Str;

class Field
{

    /**
     * @var App\Admin\Resource\Resource $resource
     */
    protected $resource;
    protected $type;
    protected $name;
    protected $label;
    protected $view;
    protected $loadUsing;
    protected $storeUsing;
    protected $showUsing;
    protected $showOn = true;
    protected $rules = [];
    protected $rulesUsing;

    /**
     * @return self
     */
    public static function make()
    {
        return new static();
    }

    /**
     * @param Resource $resource
     * @return self
     */
    public function withResource(Resource $resource)
    {
        $field = clone $this;
        $field->resource = $resource;
        return $field;
    }

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

    public function type($type = null)
    {
        if (func_num_args() == 0) {
            return $this->type;
        }
        $this->type = $type;
        return $this;
    }

    public function name($name = null)
    {
        if (func_num_args() == 0) {
            return $this->name;
        }
        $this->name = $name;
        return $this;
    }

    public function label($label = null)
    {
        if (func_num_args() == 0) {
            return $this->label;
        }
        $this->label = $label;
        return $this;
    }

    public function showOn($contexts = [])
    {
        if (func_num_args() == 0) {
            return $this->showOn;
        }
        $this->showOn = is_scalar($contexts)
                      ? Str::of($contexts)->explode('|')->toArray()
                      : $contexts;

        return $this;
    }

    public function showUsing($callback)
    {
        $this->showUsing = $callback;
        return $this;
    }

    public function view($view = null)
    {
        if (func_num_args() == 0) {
            return $this->view !== null ? $this->view : "admin.field." . $this->type();
        }
        $this->view = $view;
        return $this;
    }

    public function vm($value, $errors)
    {
        return [
            'context' => $this->context(),
            'view' => $this->view(),
            'type' => $this->type(),
            'name' => $this->name(),
            'label' => $this->label(),
            'value' => $value,
            'errors' => $errors,
        ];
    }

    public function resolveField()
    {
        if ($this->showUsing) {
            return call_user_func($this->showUsing, $this) ? clone $this : null;
        }
        return
            $this->showOn === true || in_array($this->context(), $this->showOn)
            ? clone $this
            : null;
    }

    /* value */

    public function loadUsing($callback)
    {
        $this->loadUsing = $callback;
        return $this;
    }

    public function storeUsing($callback)
    {
        $this->storeUsing = $callback;
        return $this;
    }

    public function dummy()
    {
        return null;
    }

    public function model2value()
    {
        if ($this->loadUsing) {
            return call_user_func($this->loadUsing, $this);
        }
        return $this->model()->{$this->name()};
    }

    public function value2model($value)
    {
        if ($this->storeUsing) {
            call_user_func($this->storeUsing, $this, $value);
            return;
        }
        $this->model()->{$this->name()} = $value;
    }

    public function value2union($value)
    {
        return [$this->name() => $value];
    }

    public function union2value($union)
    {
        return $union[$this->name()];
    }

    /* error */

    public function union2errors($union)
    {
        return $union[$this->name()];
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

    public function rulesUsing($callback)
    {
        $this->rulesUsing = $callback;
        return $this;
    }

    public function resolveRules()
    {
        if ($this->rulesUsing) {
            return call_user_func($this->rulesUsing, $this);
        }
        return $this->rules();
    }

    public function rules2union()
    {
        return [$this->name() => $this->resolveRules()];
    }

}

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
    protected $value;
    protected $errors;
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

    public function withUnionValue($union)
    {
        $field = clone $this;
        $field->value = $this->union2value($union);
        return $field;
    }

    public function withUnionErrors($union)
    {
        $field = clone $this;
        $field->errors = $this->union2errors($union);
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

    /**
     * @param String $type
     * @return self
     */
    public function type($type = null)
    {
        if (func_num_args() == 0) {
            return $this->type;
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @param String $type
     * @return self
     */
    public function name($name = null)
    {
        if (func_num_args() == 0) {
            return $this->name;
        }
        $this->name = $name;
        return $this;
    }

    /**
     * @param String $type
     * @return self
     */
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
        $this->showOn = $contexts;
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

    public function resolveField()
    {
        if ($this->showUsing) {
            return call_user_func($this->showUsing, $this) ? clone $this : null;
        }

        if ($this->showOn === true) {
            return clone $this;
        }

        $showOn = is_array($this->showOn) ? $this->showOn : Str::of($this->showOn)->explode('|')->toArray();

        if (in_array($this->context(), $showOn)) {
            return clone $this;
        }

        return null;
    }

    /* value */

    protected function value()
    {
        return $this->value;
    }

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

    protected function errors()
    {
        return $this->errors;
    }

    public function union2errors($union)
    {
        return $union[$this->name()] ?? null;
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

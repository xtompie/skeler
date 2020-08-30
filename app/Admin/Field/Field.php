<?php

namespace App\Admin\Field;

use App\Admin\Resource\Resource;

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
    protected $showOnIndex = true;
    protected $showOnCreate = true;
    protected $showOnDetail = true;
    protected $showOnUpdate = true;

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

    public function showOnAll($show = null)
    {
        if (func_num_args() == 0) {
            return $this->showOnIndex && $this->showOnCreate && $this->showOnDetail && $this->showOnUpdate;
        }
        $this->showOnIndex = $this->showOnCreate = $this->showOnDetail = $this->showOnUpdate = $show;
        return $this;
    }

    public function showOnIndex($show = null)
    {
        if (func_num_args() == 0) {
            return $this->showOnIndex;
        }
        $this->showOnIndex = $show;
        return $this;
    }

    public function showOnCreate($show = null)
    {
        if (func_num_args() == 0) {
            return $this->showOnCreate;
        }
        $this->showOnCreate = $show;
        return $this;
    }

    public function showOnDetail($show = null)
    {
        if (func_num_args() == 0) {
            return $this->showOnDetail;
        }
        $this->showOnDetail = $show;
        return $this;
    }

    public function showOnUpdate($show = null)
    {
        if (func_num_args() == 0) {
            return $this->showOnU;
        }
        $this->showOnU = $show;
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
            'view' => $this->view(),
            'type' => $this->type(),
            'name' => $this->name(),
            'label' => $this->label(),
            'value' => $this->value(),
        ];
    }

    public function fieldForIndex()
    {
        return $this->showOnIndex() ? clone $this : null;
    }

    public function fieldForCreate()
    {
        return $this->showOnCreate() ? clone $this : null;
    }

    public function fieldForDetail()
    {
        return $this->showOnDetail() ? clone $this : null;
    }

    public function fieldForUpdate()
    {
        return $this->showOnUpdate() ? clone $this : null;
    }

    public function value()
    {
        return $this->resource->model()->{$this->name()};
    }

}


/**
 * label
 * sortable
 * readonly
 * required
 * rules
 * rulesForCreate
 * rulesForUpdate
 * view
 *
 * post, entity, form
 * post2form, entity2form, form2entity // bo validacja form
 *
 * request model view
 * request == view
 * request2model
 * model2request


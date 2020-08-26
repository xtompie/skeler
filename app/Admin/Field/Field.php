<?php

namespace App\Admin\Field;

class Field
{

    protected $type;
    protected $name;
    protected $label;
    protected $view;
    protected $showOnIndex = true;
    protected $showOnCreate = true;
    protected $showOnDetail = true;
    protected $showOnUpdate = true;
    protected $showOnDelete = true;

    public static function make($type = null)
    {
        return new static($type);
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
            return $this->showOnIndex && $this->showOnCreate && $this->showOnDetail && $this->showOnUpdate && $this->showOnDelete;
        }
        $this->showOnIndex = $this->showOnCreate = $this->showOnDetail = $this->showOnUpdate = $this->showOnDelete = $show;
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

    public function showOnDelete($show = null)
    {
        if (func_num_args() == 0) {
            return $this->showOnDelete;
        }
        $this->showOnDelete = $show;
        return $this;
    }

    public function view($view)
    {
        if (func_num_args() == 0) {
            return $this->view !== null ? $this->view : "admin.filed." . $this->type();
        }
        $this->view = $view;
        return $this;
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

    public function fieldForDelete()
    {
        return $this->showOnDelete() ? clone $this : null;
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


<?php

namespace App\Admin\Field;

class Panel extends Field
{

    protected $type = 'panel';
    protected $showOnIndex = false;
    protected $showOnCreate = true;
    protected $showOnDetail = true;
    protected $showOnUpdate = true;
    protected $showOnDelete = false;
    protected $fields = [];

    public function fields($fields = null)
    {
        if (func_num_args() === 0) {
            return $this->fields;
        }
        $this->fields = $fields;
        return $this;
    }

    public function fieldForIndex()
    {
        if (!$this->showOnIndex()) {
            return null;
        }

        $field = clone $this;
        $field->fields = collect($field->fields())
            ->map(function($field) {
                return $field->fieldForIndex();
            })
            ->filter()
            ->toArray()
        ;
        return $field;
    }

    public function fieldForCreate()
    {
        if (!$this->showOnCreate()) {
            return null;
        }

        $field = clone $this;
        $field->fields = collect($field->fields())
            ->map(function($field) {
                return $field->fieldForCreate();
            })
            ->filter()
            ->toArray()
        ;
        return $field;
    }

    public function fieldForDetail()
    {
        if (!$this->showOnDetail()) {
            return null;
        }

        $field = clone $this;
        $field->fields = collect($field->fields())
            ->map(function($field) {
                return $field->fieldForDetail();
            })
            ->filter()
            ->toArray()
        ;
        return $field;
    }

    public function fieldForUpdate()
    {
        if (!$this->showOnUpdate()) {
            return null;
        }

        $field = clone $this;
        $field->fields = collect($field->fields())
            ->map(function($field) {
                return $field->fieldForUpdate();
            })
            ->filter()
            ->toArray()
        ;
        return $field;
    }

    public function fieldForDelete()
    {
        if (!$this->showOnDelete()) {
            return null;
        }

        $field = clone $this;
        $field->fields = collect($field->fields())
            ->map(function($field) {
                return $field->fieldForDelete();
            })
            ->filter()
            ->toArray()
        ;
        return $field;
    }

}

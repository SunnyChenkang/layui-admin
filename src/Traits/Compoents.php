<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/7
 * Time: 15:52
 */

namespace thans\layuiAdmin\Traits;

trait Compoents
{
    public $disabled = '';

    public $renderHtml = [];

    public $obj = [];

    public $id = '';

    public function load($arguments = [])
    {
        if ($arguments && is_array($arguments)) {
            foreach ($arguments as $key => $val) {
                if (isset($this->$key)) {
                    $this->$key = $val;
                }
            }
        }
    }

    public function __construct($arguments = [], &$obj = '')
    {
        $this->id = uniqid();
        $this->load($arguments);
        $this->obj = &$obj;
        if (method_exists($this,'init')) {
            $this->init();
        }
        return $this;
    }

    public function __destruct()
    {
        $this->render();
    }

    public function render()
    {
        if (method_exists($this,'end')) {
            $this->end();
        }
        $render = $this->obj->builder->display($this->tmpl,[
            'self' => $this
        ], true);
        $this->obj->builder->html[] = $render;
        return $this;
    }
    public function __call($name, $value)
    {
        if (isset($value[0]) && is_array($value[0])) {
            return $this;
        }
        if (isset($this->$name)) {
            $this->$name = $value[0]?:'';
        }
        return $this;
    }
}

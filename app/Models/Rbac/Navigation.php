<?php


namespace App\Models\Rbac;


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Navigation
{
    public $children = null;
    public $subNavigation = null;
    public $attributes = [];

    function __construct($attributes)
    {
        $this->children = new Collection();
        $this->subNavigation = [];
        foreach ($attributes as $name => $value) {
            $this->attributes[$name] = $value;
        }
    }

    function __get($name)
    {
        return Arr::get($this->attributes, $name);
    }

    function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    function hasChildren()
    {
        return $this->children && !empty($this->children);
    }
}

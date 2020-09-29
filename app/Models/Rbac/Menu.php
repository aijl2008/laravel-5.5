<?php

namespace App\Models\Rbac;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'url',
        'parent_id',
        'ico',
        'target',
        'order_no',
        'status'
    ];

    protected $hasChildren = null;
    protected $children = null;

    protected $appends = ['real_url'];

    function getRealUrlAttribute()
    {
        if ($this->attributes['url'] === '###') {
            return '###';
        }
        if (substr($this->attributes['url'], 0, 1) !== '/') {
            return '/' . $this->attributes['url'];
        }
        return $this->attributes['url'];
    }

    function __construct(array $attributes = [])
    {
        $this->connection = config('rbac.database.connection');
        $this->table = config('rbac.database.table_pre') . 'menus';
        parent::__construct($attributes);
    }

    function scopeParent($query, $id)
    {
        $query->where('parent_id', $id);
    }

    function hasChildren()
    {
        if (isset($this->hasChildren)) {
            return $this->hasChildren;
        }
        return $this->newQuery()->where('parent_id', $this->id)->count('id') > 0;
    }

    function children()
    {
        if (isset($this->children)) {
            return $this->children;
        }
        return $this->newQuery()->where('parent_id', $this->id)->get();
    }
}

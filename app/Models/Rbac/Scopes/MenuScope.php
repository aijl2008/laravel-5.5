<?php
namespace App\Models\Rbac\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Request;

class MenuScope implements Scope {

    public function apply ( Builder $builder , Model $model ) {
        return $builder->where ( [
            [
                "parent_id" ,
                Request::route ()->parameter ( "parent_id" )
            ]
        ] );
    }
}
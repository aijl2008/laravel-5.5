<?php
namespace App\Models\Rbac\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Request;

class PermissionScope implements Scope {

    public function apply ( Builder $builder , Model $model ) {
        return $builder->where ( [
            [
                "role_id" ,
                Request::route ()->parameter ( "role" )
            ]
        ] );
    }
}
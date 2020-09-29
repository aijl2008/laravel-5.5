<?php
namespace App\Models\Rbac;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {

    public    $timestamps = true;
    protected $primaryKey = 'id';
    protected $userId     = '';

    protected $fillable = [
        'role_id' ,
        'user_id'
    ];

    function __construct ( array $attributes = [ ] ) {
        $this->connection = config ( 'rbac.database.connection' );
        $this->table = config ( 'rbac.database.table_pre' ) . 'role_user';
        parent::__construct ( $attributes );
    }


    public function hasRole ( $userId , $roleId ) {
        foreach ( $this->where ( 'user_id' , $userId )->where ( 'role_id' , $roleId )->get () as $item ) {
            if ( $item->role_id == $roleId ) {
                return true;
            }
        }
        return false;
    }
}
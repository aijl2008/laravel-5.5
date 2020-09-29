<?php
namespace App\Models\Rbac;

use App\Models\Rbac\Scopes\PermissionScope;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    public $timestamps = true;

    protected $primaryKey = 'id';
    protected $fillable   = [
        'name' ,
        'note'
    ];


    function __construct ( array $attributes = [ ] ) {
        $this->connection = config ( 'rbac.database.connection' );
        $this->table = config ( 'rbac.database.table_pre' ) . 'roles';
        parent::__construct ( $attributes );
    }


    public function users () {
        return $this->belongsToMany ( User::class , config ( 'rbac.database.table_pre' ) . 'role_user' );
    }

    public function permissions () {
        return $this->hasMany ( Permission::class )->withoutGlobalScope ( PermissionScope::class );
    }
}

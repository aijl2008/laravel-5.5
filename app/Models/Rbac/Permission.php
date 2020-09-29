<?php
namespace App\Models\Rbac;

use App\Models\Rbac\Scopes\PermissionScope;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    public    $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable   = [
        'role_id' ,
        'uri' ,
        'route'
    ];

    function __construct ( array $attributes = [ ] ) {
        $this->connection = config ( 'rbac.database.connection' );
        $this->table = config ( 'rbac.database.table_pre' ) . 'role_actions';
        parent::__construct ( $attributes );
    }

    protected static function boot () {
        parent::boot ();
        static::addGlobalScope ( new PermissionScope() );
    }
}

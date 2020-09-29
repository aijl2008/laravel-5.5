<?php
namespace App\Models\Rbac;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Log extends Model {
    /**
     * 是否由Laravel维护created_at和updated_at
     */
    public $timestamps = true;
    /**
     * 主键字段名
     */
    protected $primaryKey = 'id';
    /**
     * 可以被批量添加的字段名
     */
    protected $fillable = [
        'user_id' ,
        'connection' ,
        'sql' ,
        'bindings' ,
        'time' ,
        'ip',
        'ua'
    ];

    function __construct ( array $attributes = [ ] ) {
        $this->connection = config('rbac.database.connection');
        $this->table = config('rbac.database.table_pre') . 'logs';
        parent::__construct($attributes);
    }
}

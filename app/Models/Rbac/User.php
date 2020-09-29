<?php

namespace App\Models\Rbac;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use Notifiable;

    protected $permission = null;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'username',
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = true;

    function __construct(array $attributes = [])
    {
        $this->connection = config('rbac.database.connection');
        $this->table = config('rbac.database.table_pre') . 'users';
        parent::__construct($attributes);
    }

    function retrieveById($id)
    {
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->primaryKey;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * 当前用户是否有root权限
     * @return bool
     */
    public function hasRootPermission()
    {
        return $this->getAuthIdentifier() === 1;
    }


    /**
     * 取用户所有的权限
     */
    public function permissions()
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                if (substr($permission->uri, 0, 1) == '/') {
                    $permissions[] = $permission->uri;
                } else {
                    try {
                        if (isset($permission->route) && $permission->route) {
                            $permissions[] = route($permission->uri, $permission->route, false);
                        } else {
                            $permissions[] = route($permission->uri, [], false);
                        }
                    } catch (\Exception $e) {
                        $permissions[] = $permission->uri . '[ERROR]';
                    }
                }
            }
        }
        return $permissions;
    }

    /**
     * 验证当前用户是否有指定的权限
     * @param  strint $permission 权限内容,这里指url中的path部分
     * @return bool
     */
    public function hasPermission($url)
    {
        if (substr($url, 0, 1) != '/') {
            $url = '/' . $url;
        }
        if ($this->hasRootPermission()) {
            return true;
        }
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                /**
                 * 从角色动作表中，解析出uri
                 */
                if (substr($permission->uri, 0, 1) == '/') {
                    $uri = $permission->uri;
                } else {
                    try {
                        if (isset($permission->route) && $permission->route) {
                            $uri = route($permission->uri, $permission->route, false);
                        } else {
                            $uri = route($permission->uri, [], false);
                        }
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('解析路由失败' . $permission->uri);
                    }
                }
                /**
                 * 开始比对
                 */
                if (substr($uri, 0, 1) === "*" || substr($uri, -1) === "*") {
                    if (stripos($url, trim($uri, "*")) === 0) {
                        return true;
                    }
                    if (stripos($uri, $url) === 0) {
                        return true;
                    }
                } else {
                    if ($url === $uri) {
                        return true;
                    }
                }
            }
        }
        return false;
    }


    function roles()
    {
        return $this->belongsToMany(Role::class, config('rbac.database.table_pre') . 'role_user');
    }
}

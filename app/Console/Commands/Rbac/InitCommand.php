<?php

namespace App\Console\Commands\Rbac;

use App\Models\Rbac\Menu;
use App\Models\Rbac\Permission;
use App\Models\Rbac\Role;
use App\Models\Rbac\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InitCommand extends Command
{
    protected $signature = 'rbac:init {email}';
    protected $description = '初始化并创建管理员用户';

    function handle()
    {
        try {
            DB::beginTransaction();
            $User = new User();
            $User->fill([
                'name' => '管理员',
                'email' => $email = $this->argument('email'),
                'password' => Hash::make($password = Str::random(8))
            ]);
            $User->save();

            $Menu = new Menu();
            $Menu->fill([
                'name' => '权限管理',
                'url' => '###',
                'ico' => '',
                'target' => '',
                'parent_id' => 0,
                'order_no' => 0,
                'status' => 1
            ]);
            $Menu->save();

            $Menu = new Menu();
            $Menu->fill([
                'name' => '用户管理',
                'url' => '/rbac/user',
                'ico' => '',
                'target' => '',
                'parent_id' => 1,
                'order_no' => 0,
                'status' => 1
            ]);
            $Menu->save();

            $Menu = new Menu();
            $Menu->fill([
                'name' => '角色管理',
                'url' => '/rbac/role',
                'ico' => '',
                'target' => '',
                'parent_id' => 1,
                'order_no' => 0,
                'status' => 1
            ]);
            $Menu->save();

            $Menu = new Menu();
            $Menu->fill([
                'name' => '菜单',
                'url' => '/rbac/0/menu',
                'ico' => '',
                'target' => '',
                'parent_id' => 1,
                'order_no' => 0,
                'status' => 1
            ]);
            $Menu->save();

            $Menu = new Menu();
            $Menu->fill([
                'name' => '日志',
                'url' => '/rbac/log',
                'ico' => '',
                'target' => '',
                'parent_id' => 1,
                'order_no' => 0,
                'status' => 1
            ]);
            $Menu->save();


            $Role = new Role();
            $Role->fill([
                'name' => '权限管理',
                'note' => '权限管理'
            ]);
            $Role->save();

            $Role->users()->attach($User->id);


            $Role->permissions()->save(new Permission([
                'uri' => '/rbac*',
                'route' => ''
            ]));

            DB::commit();
            $this->comment("管理员账号{$email}已创建，密码为:{$password}");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
            $this->comment($e->getTraceAsString());
        }
    }
}
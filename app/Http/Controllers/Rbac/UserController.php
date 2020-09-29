<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rbac\UserRequest;
use App\Models\Rbac\Menu;
use App\Models\Rbac\Role;
use App\Models\Rbac\RoleUser;
use App\Models\Rbac\User;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!empty(config('rbac.oauth'))) {
            $model = new class
            {
                protected $search = "";

                function where($field, $expr, $val)
                {
                    $this->search = $val;
                    return $this;

                }

                function orWhere($field, $expr, $val)
                {
                    $this->search = $val;
                    return $this;
                }

                function paginate()
                {
                    $perPage = 20;
                    $pageName = 'page';
                    $page = Paginator::resolveCurrentPage($pageName);
                    $api = config('rbac.oauth.server') . "/user?w=" . urlencode($this->search);
                    $response = json_decode(file_get_contents($api));
                    if (!$response || !isset($response->total) || $response->total == 0) {
                        return $this->paginator(collect([]), 0, $perPage, $page, [
                            'path' => Paginator::resolveCurrentPath(),
                            'pageName' => $pageName,
                        ]);
                    }
                    return $this->paginator(collect($response->data), $response->total, $perPage, $page, [
                        'path' => Paginator::resolveCurrentPath(),
                        'pageName' => $pageName,
                    ]);
                }

                protected function paginator($items, $total, $perPage, $currentPage, $options)
                {
                    return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
                        'items', 'total', 'perPage', 'currentPage', 'options'
                    ));
                }
            };
        } else {
            $model = (new User())->orderBy('id', 'desc');
        }
        if ($w = $request->get('w')) {
            $model = $model->where('name', 'like', '%' . $w . '%')->orWhere('email', 'like', '%' . $w . '%');
        }
        return view('rbac.user.index', [
            'rows' => $model->paginate()
        ]);
    }

    public function create()
    {
        if (!empty(config('rbac.oauth'))) {
            abort(404);
        }
        return view('rbac.user.create', [
            'model' => new User(),
            'roles' => (new Role())->all()
        ]);
    }

    public function store(UserRequest $request)
    {
        if (!empty(config('rbac.oauth'))) {
            abort(404);
        }

        $User = new User();
        $User->fill($request->fillData());
        $User->save();
        foreach ($request->only('RoleId') as $RoleId) {
            if (!$RoleId) {
                break;
            }
            $User->roles()->sync($RoleId);
        }
        return redirect()->route('rbac.user.index')->with('success', '成功添加了' . $request->User);
    }

    public function edit($id)
    {
        if (!empty(config('rbac.oauth'))) {
            abort(404);
        }

        return view('rbac.user.edit', [
            'model' => (new class extends User
            {
                function getPasswordAttribute()
                {
                    $this->attributes['password'] = '';
                }
            })->findorfail($id)
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        if (!empty(config('rbac.oauth'))) {
            abort(404);
        }

        $User = (new User())->findorfail($id);
        $User->fill($request->FillData());
        $User->save();
        return redirect()->route('rbac.user.index')->with('success', '成功修改了' . $request->UserName);
    }

    public function role($id)
    {
        if (!!empty(config('rbac.oauth'))) {
            (new User())->findorfail($id);
        }
        return view('rbac.user.role', [
            'model' => (new RoleUser()),
            'roles' => (new Role())->all(),
            'userId' => $id
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        if (!!empty(config('rbac.oauth'))) {
            (new User())->findorfail($id);
        }
        $RoleUser = new RoleUser();
        $RoleUser->where('user_id', $id)->delete();
        foreach ($request->input('role_id', []) as $roleId) {
            RoleUser::query()->create([
                'role_id' => $roleId,
                'user_id' => $id
            ]);
        }
        return redirect()->back()->with('success', '授权成功');
    }

    public function destroy($id)
    {
        if (!empty(config('rbac.oauth'))) {
            abort(403);
        }

        $user = (new User())->findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', '成功删除了' . $user->UserName);
    }

    public function authUser(Request $request, $uid)
    {
        $user = User::query()->firstOrNew([
            'id' => $uid
        ]);
        return $user->roles->toArray();
    }

    public function authUsers(Request $request, $uid)
    {
        $dashboard = [];
        $Pinyin = new \Overtrue\Pinyin\Pinyin();
        $user = \App\Models\Rbac\User::query()->firstOrNew([
            'id' => $uid
        ]);
        foreach ((new Menu())->parent(0)->get() as $item) {
            if ($user->hasPermission($item->real_url)) {
                $dashboard[strtoupper(substr($Pinyin->convert($item->name)[0], 0, 1))][] = [
                    'name' => $item->name,
                    'link' => $item->real_url
                ];
            }
        }
        ksort($dashboard);
        return $dashboard;
    }
}

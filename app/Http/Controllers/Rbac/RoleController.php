<?php
namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rbac\RoleRequest;
use App\Models\Rbac\Role;
use Illuminate\Http\Request;
use Session;

class RoleController extends Controller {
    
    public function index ( Request $request ) {
        $keyword = $request->get ( 'w' );
        $perPage = 25;
        if ( !empty( $keyword ) ) {
            $roles = Role::where ( 'name' , 'LIKE' , '%' . $keyword . '%' )->orWhere ( 'note' , 'LIKE' , '%' . $keyword . '%' )->paginate ( $perPage );
        } else {
            $roles = Role::paginate ( $perPage );
        }
        return view ( 'rbac.role.index' , compact ( 'roles' ) );
    }

    public function create () {
        return view ( 'rbac.role.create' );
    }

    public function store ( RoleRequest $request ) {
        $requestData = $request->data ();
        Role::create ( $requestData );
        return redirect ( route ( "rbac.role.index" ) )->with ( 'status' , '角色已添加' );
    }

    public function show ( RoleRequest $request ) {
        $id = $request->route ( 'role' );
        $role = Role::findOrFail ( $id );
        return view ( 'rbac.role.show' , compact ( 'role' ) );
    }

    public function edit ( Request $request ) {
        $id = $request->route ( 'role' );
        $role = Role::findOrFail ( $id );
        return view ( 'rbac.role.edit' , compact ( 'role' ) );
    }

    public function update ( RoleRequest $request ) {
        $id = $request->route ( 'role' );
        $requestData = $request->data ();
        $role = Role::findOrFail ( $id );
        $role->update ( $requestData );
        return redirect ( route ( "rbac.role.index" ) )->with ( 'status' , '角色已更新' );
    }

    public function destroy ( Request $request ) {
        $id = $request->route ( 'role' );
        Role::destroy ( $id );
        return redirect ( route ( "rbac.role.index" ) )->with ( 'status' , '角色已删除' );
    }
}

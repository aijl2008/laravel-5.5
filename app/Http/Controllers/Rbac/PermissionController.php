<?php
namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rbac\PermissionRequest;
use App\Models\Rbac\Permission;
use Illuminate\Http\Request;
use Session;

class PermissionController extends Controller {
    
    public function index ( Request $request ) {
        $keyword = $request->get ( 'w' );
        $perPage = 25;
        if ( !empty( $keyword ) ) {
            $permissions = Permission::where ( 'controller' , 'LIKE' , '%' . $keyword . '%' )->orWhere ( 'action' , 'LIKE' , '%' . $keyword . '%' )->paginate ( $perPage );
        } else {
            $permissions = Permission::paginate ( $perPage );
        }
        return view ( 'rbac.permission.index' , compact ( 'permissions' ) );
    }

    public function create () {
        return view ( 'rbac.permission.create' );
    }

    public function store ( PermissionRequest $request ) {
        $requestData = $request->data ();
        Permission::create ( $requestData );
        Session::flash ( 'flash_message' , 'Permission added!' );
        return redirect ( route ( "rbac.permission.index" , $request->route ( 'role' ) ) );
    }

    public function show ( PermissionRequest $request ) {
        $id = $request->route ( 'permission' );
        $permission = Permission::findOrFail ( $id );
        return view ( 'rbac.permission.show' , compact ( 'permission' ) );
    }

    public function edit ( Request $request ) {
        $id = $request->route ( 'permission' );
        $permission = Permission::findOrFail ( $id );
        return view ( 'rbac.permission.edit' , compact ( 'permission' ) );
    }

    public function update ( PermissionRequest $request ) {
        $id = $request->route ( 'permission' );
        $requestData = $request->data ();
        $permission = Permission::findOrFail ( $id );
        $permission->update ( $requestData );
        Session::flash ( 'flash_message' , 'Permission updated!' );
        return redirect ( route ( "rbac.permission.index" , $request->route ( 'role' ) ) );
    }

    public function destroy ( Request $request ) {
        $id = $request->route ( 'permission' );
        Permission::destroy ( $id );
        Session::flash ( 'flash_message' , 'Permission deleted!' );
        return redirect ( route ( "rbac.permission.index" , $request->route ( 'role' ) ) );
    }
}
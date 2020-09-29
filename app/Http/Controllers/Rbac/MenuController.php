<?php
namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rbac\MenuRequest;
use App\Models\Rbac\Menu;
use Illuminate\Http\Request;
use Session;

class MenuController extends Controller {

    public function index ( Request $request ) {
        $keyword = $request->get ( 'w' );
        $perPage = 25;
        $parent = (int) $request->route ( 'parent' );
        $menus = Menu::when ( $keyword , function ( $query ) use ( $keyword ) {
            return $query->where ( 'name' , 'LIKE' , '%' . $keyword . '%' )->orWhere ( 'url' , 'LIKE' , '%' . $keyword . '%' );
        } )->where ( 'parent_id' , $parent )->orderBy ( 'order_no' )->paginate ( $perPage );
        return view ( 'rbac.menu.index' , compact ( 'menus' ) );
    }

    public function create () {
        return view ( 'rbac.menu.create' );
    }

    public function store ( MenuRequest $request ) {
        $requestData = $request->data ();
        Menu::create ( $requestData );
        Session::flash ( 'flash_message' , 'Menu added!' );
        return redirect ( route ( "rbac.menu.index" , $request->route ( 'parent' ) ) );
    }

    public function show ( MenuRequest $request ) {
        $id = $request->route ( 'menu' );
        $menu = Menu::findOrFail ( $id );
        return view ( 'rbac.menu.show' , compact ( 'menu' ) );
    }

    public function edit ( Request $request ) {
        $id = $request->route ( 'menu' );
        $menu = Menu::findOrFail ( $id );
        return view ( 'rbac.menu.edit' , compact ( 'menu' ) );
    }

    public function update ( MenuRequest $request ) {
        $id = $request->route ( 'menu' );
        $requestData = $request->data ();
        $menu = Menu::findOrFail ( $id );
        $menu->update ( $requestData );
        return redirect ( route ( "menu.index" , $request->route ( 'parent' ) ) )->with ( 'status' , '菜单更新成功!' );
    }

    public function destroy ( Request $request ) {
        $id = $request->route ( 'menu' );
        Menu::destroy ( $id );
        return redirect ( route ( "rbac.menu.index" , $request->route ( 'parent' ) ) )->with ( 'status' , '菜单删除成功!' );
    }
}

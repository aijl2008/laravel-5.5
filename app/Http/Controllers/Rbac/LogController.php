<?php
namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rbac\LogRequest;
use App\Models\Rbac\Log;
use Illuminate\Http\Request;
use Session;

/**
 * Class LogControllerController
 */
class LogController extends Controller {

    /**
     * 列表页
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index ( Request $request ) {
        $view = view ( 'rbac.log.index' );
        $rows = Log::orderBy ( 'id' , 'desc' )->paginate ();
        $view->with ( 'rows' , $rows );
        return $view;
    }

    /**
     * 删除指定的资源
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy ( Request $request , $id ) {
        Log::destroy ( $id );
        return redirect ()->route ( 'rbac.log.index' , [ ] )->with ( 'success' , '删除成功' );
    }


}
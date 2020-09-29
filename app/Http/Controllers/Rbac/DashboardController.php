<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Models\Rbac\Menu;
use Illuminate\Http\Request;
use Overtrue\Pinyin\Pinyin;

class DashboardController extends Controller
{
    protected $menu = 1;


    function index(Request $request, $parentId = 0)
    {
        $dashboard = array();
        $Pinyin = new Pinyin();
        foreach ((new Menu())->parent($parentId)->get() as $item) {
            if ($request->user()->hasPermission($item->real_url)) {
                $dashboard[strtoupper(substr($Pinyin->convert($item->name)[0], 0, 1))][] = [
                    'name' => $item->name,
                    'link' => ($item->real_url =='###')?(route('rbac.dashboard', $item->id)):$item->real_url
                ];
            }
        }
        ksort($dashboard);
        return view('my.dashboard', ['dashboard' => $dashboard]);
    }
}

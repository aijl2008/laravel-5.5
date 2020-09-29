@extends(config('rbac.view.prefix').'layouts.app')
@section('title', '仪表盘')
@section('content')
    <div class="row">
        <div class="col-md-6">
            仪表盘
            <table class="table table-striped table-hover" width="100%">
                @foreach($dashboard as $letter => $menus)
                    <tr>
                        <td>{{$letter}}</td>
                        <td>
                            @foreach ($menus as $menu)
                            <a href="{{$menu['link']}}">{{$menu['name']}}</a>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
@stop
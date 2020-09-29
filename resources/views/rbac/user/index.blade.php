@extends(config('rbac.view.prefix').'layouts.app')
@section('title', '用户管理')
@section('tip')
    用户管理
@stop

@section('button')
    <div class="input-group-btn">
        <a href="{!! route('rbac.user.create') !!}" class="btn btn-primary active">新建</a>
    </div>
@stop

@section('search')
    <form action="{!! route('rbac.user.index') !!}" method="get" class="form-inline">
        <div class="input-group">
            <input type="text" name="w" id="w" value="{{ Request::get('w') }}"
                   class="form-control pull-right"
                   placeholder="请输入关键字">
            <div class="input-group-btn">
                <button onclick="javascript:if (!$('#w').val()){alert('请输入关键字');return false;}"
                        type="submit" class="btn btn-default">搜索
                </button>
            </div>
        </div>
    </form>
@stop

@section('content')
    @if ($status = Session::get('status'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $status }}</strong>
        </div>
    @endif
    <table class="table table-hover">
        <tr>
            <th><input type="checkbox"></th>
            <th>编号</th>
            <th>姓名</th>
            <th>邮箱</th>
            <th>Action</th>
        </tr>
        @if (count($rows)>0)
            @foreach($rows as $row)
                <tr>
                    <td><input type="checkbox" name="id" value="{{$row->id}}"></td>
                    <td>{{$row->id}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->email}}</td>
                    <td>@if (config('rbac.oauth.openId'))<a href="{{route('rbac.user.edit',[$row->id])}}"
                                                            class="btn-sm btn-info">编辑</a>
                        <a href="{{ route('rbac.user.destroy', [$row->id]) }}"
                           class="btn-sm btn-danger delete"
                           data-toggle="modal" data-target="#modal-delete">删除</a>
                        @endif
                        <a href="{{route('rbac.user.role',[$row->id])}}"
                           class="btn-sm btn-warning">授权</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4">
                    @include(config('rbac.view.prefix').'layouts.no-recards')
                </td>
            </tr>
        @endif
    </table>
    {{ $rows->links() }}
@stop
@section('css')
@stop
@section('js')
    <script type="text/javascript">
        $(function () {
            $(".table th input[type='checkbox']").click(function () {
                if ($(this).is(':checked')) {
                    $(".table td input[type='checkbox']").attr("checked", true);
                }
                else {
                    $(".table td input[type='checkbox']").removeAttr("checked");
                }
            });
        });
    </script>
@stop

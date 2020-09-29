@extends(config('rbac.view.prefix').'layouts.app')
@section('title', 'Permissions')
@section('tip')
    权限管理
@stop

@section('button')
    <div class="input-group-btn">
        <a href="{{ route('rbac.permission.create' , Request::route('role')) }}" class="btn btn-primary active">新建</a>
        @if (count($permissions)>0)
            <a href="###"
               class="btn btn-primary truncate">删除选中</a>
        @endif
    </div>
@stop

@section('search')
    <form action="{{ route('rbac.permission.index' , Request::route('role')) }}" method="get" class="form-inline">
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
    <table class="table table-borderless">
        <thead>
        <tr>
            <th><input type="checkbox"></th>
            <th>编号</th>
            <th>角色编号</th>
            <th>资源路径</th>
            <th>路由参数</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($permissions as $item)
            <tr>
                <td><input type="checkbox" name="id" value="{{ $item->id }}"></td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->role_id }}</td>
                <td>{{ $item->uri }}</td>
                <td>{{ $item->route }}</td>
                <td>
                    <a href="{{ route('rbac.permission.edit' , [ Request::route('role'), $item->id ]) }}"
                       title="编辑 permission">
                        <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>编辑
                        </button>
                    </a>
                    {!! Form::open([
                        'method'=>'DELETE',
                        'route' => ['rbac.permission.destroy', Request::route('role'), $item->id ],
                        'style' => 'display:inline'
                    ]) !!}
                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>删除', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-xs',
                            'title' => 'Delete permission',
                            'onclick'=>'return confirm("Confirm delete?")'
                    )) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper"> {!! $permissions->appends(['search' => Request::get('search')])->render() !!} </div>
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
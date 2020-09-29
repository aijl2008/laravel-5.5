@extends(config('rbac.view.prefix').'layouts.app')
@section('title', 'Roles')
@section('tip')
    角色管理
@stop

@section('button')
    <div class="input-group-btn">
        <a href="{{ route('rbac.role.create') }}" class="btn btn-primary active">新建</a>
        @if (count($roles)>0)
            <a href="###"
               class="btn btn-primary truncate">删除选中</a>
        @endif
    </div>
@stop

@section('search')
    <form action="{{ route('rbac.role.index') }}" method="get" class="form-inline">
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
    <table class="table table-borderless">
        <thead>
        <tr>
            <th><input type="checkbox"></th>
            <th>编号</th>
            <th>名称</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $item)
            <tr>
                <td><input type="checkbox" name="id" value="{{ $item->id }}"></td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->note }}</td>
                <td>
                    <a href="{{ route('rbac.role.edit', $item->id) }}" title="编辑">
                        <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>编辑
                        </button>
                    </a>
                    <a href="{{ route('rbac.permission.index', $item->id ) }}" title="授权">
                        <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>授权
                        </button>
                    </a>
                    {!! Form::open([
                        'method'=>'DELETE',
                        'route' => ['rbac.role.destroy', $item->id],
                        'style' => 'display:inline'
                    ]) !!}
                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>删除', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-xs',
                            'title' => 'Delete role',
                            'onclick'=>'return confirm("Confirm delete?")'
                    )) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper"> {!! $roles->appends(['search' => Request::get('search')])->render() !!} </div>
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
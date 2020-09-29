@extends(config('rbac.view.prefix').'layouts.app')
@section('title', 'Menus')
@section('tip')
    菜单管理
@stop

@section('button')
    <div class="input-group-btn">
        <a href="{{ route('rbac.menu.create' , Request::route('parent')) }}" class="btn btn-primary active">新建</a>
        @if (count($menus)>0)
            <a href="###"
               class="btn btn-primary truncate">删除选中</a>
        @endif
    </div>
@stop

@section('search')
    <form action="{{ route('rbac.menu.index' , Request::route('parent')) }}" method="get" class="form-inline">
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
            <th>菜单名称</th>
            <th>资源路径</th>
            <th>显示顺序</th>
            <th>父级编号</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($menus as $item)
            <tr>
                <td><input type="checkbox" name="id" value="{{ $item->id }}"></td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td><a href="{{ $item->real_url }}" target="_blank"> {{ $item->url }}</a></td>
                <td>{{ $item->order_no }}</td>
                <td>{{ $item->parent_id }}</td>
                <td>
                    <a href="{{ route('rbac.menu.index' , $item->id) }}"
                       title="子 menu">
                        <button class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>子单菜
                        </button>
                    </a>
                    <a href="{{ route('rbac.menu.edit' , [ Request::route('parent') , $item->id ]) }}"
                       title="编辑 menu">
                        <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>编辑
                        </button>
                    </a>
                    {!! Form::open([
                        'method'=>'DELETE',
                        'route' => ['rbac.menu.destroy' , Request::route('parent') , $item->id],
                        'style' => 'display:inline'
                    ]) !!}
                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>删除', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-xs',
                            'title' => 'Delete menu',
                            'onclick'=>'return confirm("Confirm delete?")'
                    )) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper"> {!! $menus->appends(['search' => Request::get('search')])->render() !!} </div>
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
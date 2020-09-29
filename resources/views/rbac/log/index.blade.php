@extends(config('rbac.view.prefix').'layouts.app')
@section('title', '操作日志')
@section('tip')
    操作日志
@stop
@section('content')
    <table class="table table-borderless">
        <thead>
        <tr>
            <th>操作</th>
            <th class="text-nowrap">时间</th>
            <th class="text-nowrap">客户端</th>
            <th class="text-nowrap">管理员ID</th>
            <th class="text-nowrap">数据库连接</th>
            <th class="text-nowrap">SQL</th>
            <th class="text-nowrap">运行时长</th>
        </tr>
        </thead>
        <tbody>

        @foreach($rows as $row)
            <tr>
                <td class="text-nowrap">
                    <a href='{{ route('rbac.log.destroy', [$row->id]) }}' class='btn-sm btn-danger delete'
                       data-toggle='modal' data-target='#modal-delete'>删除</a>
                </td>
                <td class="text-nowrap">{{ $row->created_at }}</td>
                <td class="text-nowrap"><a href="###" class="piece">{{ $row->ip }}<div style="display: none">{{$row->ua}}</div></a></td>
                <td class="text-nowrap">{{ $row->user_id }}</td>
                <td class="text-nowrap">{{ $row->connection }}</td>
                <td class="text-nowrap">
                    <a href="###" class="piece">{{ str_limit($row->sql, 60) }}
                        <div style="display: none">{{$row->sql}}{{PHP_EOL}}{{var_export(json_decode($row->bindings))}}</div>
                    </a>
                </td>
                <td class="text-nowrap">{{ $row->time }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper"> {!! $rows->appends(['w' => Request::get('w')])->render() !!} </div>

    <div id="rbac-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <pre class="bindings"></pre>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <style>
        pre {
            white-space: pre-wrap
        }
    </style>
@stop
@section('js')
    <script>
        $(function () {
            $('.piece').each(function () {
                var data = $(this).find('div').html();
                $(this).on('click', function () {
                    $(".bindings").html(data);
                    $('#rbac-modal').modal({"show": true})
                });
            });
        });
    </script>
@stop

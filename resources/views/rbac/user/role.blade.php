@extends(config('rbac.view.prefix').'layouts.app')
@section('title', '用户管理')
@section('tip')
    用户授权
@stop

@section('content')
    {!! Form::model($model, ['route' => ['rbac.user.role.update', Request::route('user')], 'class' => 'form-horizontal']) !!}
    @include('rbac.user.inc.role')
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('保存',['class'=>'btn btn-primary']) !!}
            <a href="{!! route('rbac.user.index') !!}" class="btn btn-primary">返回列表</a>
        </div>
    </div>
    {!! Form::close() !!}
@stop
@section('css')
@stop
@section('js')
@stop

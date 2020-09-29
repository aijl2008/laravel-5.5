@extends(config('rbac.view.prefix').'layouts.app')
@section('title', '用户管理')
@section('tip')
    编辑用户
@stop

@section('content')

    {!! Form::model($model, ['method' => 'POST','route' => 'rbac.profile.update', 'class' => 'form-horizontal']) !!}
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        {!! Form::label('name','姓名', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'请输入姓名']) !!}
            <span class="text-danger">{{ $errors->first('name') }}</span></div>
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        {!! Form::label('password','密码', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('password', null, ['class'=>'form-control', 'placeholder'=>'请输入密码']) !!}
            <span class="text-danger">{{ $errors->first('password') }}</span></div>
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::label('email','邮箱', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'请输入邮箱','readonly'=>'readonly']) !!}
            <span class="text-danger">{{ $errors->first('email') }}</span></div>
    </div>
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
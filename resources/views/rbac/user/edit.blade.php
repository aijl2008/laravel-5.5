@extends(config('rbac.view.prefix').'layouts.app')
@section('title', '用户管理')
@section('tip')
    编辑用户
@stop

@section('content')

    {!! Form::model($model, ['method' => 'PATCH','route' => ['rbac.user.update', $model->id], 'class' => 'form-horizontal']) !!}
    @include('rbac.user.field')
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
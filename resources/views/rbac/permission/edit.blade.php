@extends(config('rbac.view.prefix').'layouts.app')
@section('title', 'Permissions')
@section('tip')
    权限管理
@stop

@section('content')

    {!! Form::model($permission, [
                                'method' => 'PATCH',
                                'route' => ['rbac.permission.update' , Request::route('role'), $permission->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
        @include ('rbac.permission.form', ['submitButtonText' => 'Update'])
    {!! Form::close() !!}
@endsection
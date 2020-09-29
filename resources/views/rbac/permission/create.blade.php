@extends(config('rbac.view.prefix').'layouts.app')
@section('title', 'Permissions')
@section('tip')
    权限管理
@stop

@section('content')

    {!! Form::open(['route' => ['rbac.permission.store' , Request::route('role')], 'class' => 'form-horizontal', 'files' => true]) !!}
        @include ('rbac.permission.form')
    {!! Form::close() !!}
@endsection
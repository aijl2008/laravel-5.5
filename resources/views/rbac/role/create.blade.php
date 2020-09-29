@extends(config('rbac.view.prefix').'layouts.app')
@section('title', 'Roles')
@section('tip')
    角色管理
@stop

@section('content')

    {!! Form::open(['route' => 'rbac.role.store', 'class' => 'form-horizontal', 'files' => true]) !!}
        @include ('rbac.role.form')
    {!! Form::close() !!}
@endsection
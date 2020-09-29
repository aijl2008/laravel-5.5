@extends(config('rbac.view.prefix').'layouts.app')
@section('title', 'Menus')
@section('tip')
    菜单管理
@stop

@section('content')

    {!! Form::open(['route' => ['rbac.menu.store', Request::route('parent')], 'class' => 'form-horizontal', 'files' => true]) !!}
    @include ('rbac.menu.form')
    {!! Form::close() !!}
@endsection
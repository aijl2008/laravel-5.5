@extends(config('rbac.view.prefix').'layouts.app')
@section('title', 'Menus')
@section('tip')
    菜单管理
@stop

@section('content')

    {!! Form::model($menu, [
                                'method' => 'PATCH',
                                'route' => ['rbac.menu.update' , Request::route('parent') , $menu->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
    @include ('rbac.menu.form', ['submitButtonText' => 'Update'])
    {!! Form::close() !!}
@endsection
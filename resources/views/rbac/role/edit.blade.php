@extends(config('rbac.view.prefix').'layouts.app')
@section('title', 'Roles')
@section('tip')
    角色管理
@stop

@section('content')

    {!! Form::model($role, [
                                'method' => 'PATCH',
                                'route' => ['rbac.role.update', $role->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
        @include ('rbac.role.form', ['submitButtonText' => 'Update'])
    {!! Form::close() !!}
@endsection
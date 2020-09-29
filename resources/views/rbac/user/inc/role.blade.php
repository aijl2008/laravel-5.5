<div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
    {!! Form::label('role_id[]','角色', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        @foreach($roles as $role)
            <div class="col-xs-6">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('role_id[]', $role->id, $model->hasRole($userId,$role->id)) !!} {!! $role->name !!}
                    </label>
                </div>
            </div>
        @endforeach</div>
</div>
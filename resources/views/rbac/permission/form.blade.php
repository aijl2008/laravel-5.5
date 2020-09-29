<div class="form-group {{ $errors->has('controller') ? 'has-error' : ''}}">
    {!! Form::label('uri', '资源路径', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::text('uri', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('uri', '<p class="help-block">:message</p>') !!}
        <span class="help-block">支持URL和路由,以"/"开始时,视为URL,否则视为路由名称</span>
    </div>
</div>
<div class="form-group {{ $errors->has('action') ? 'has-error' : ''}}">
    {!! Form::label('route', '路由参数', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::text('route', null, ['class' => 'form-control']) !!}
        {!! $errors->first('route', '<p class="help-block">:message</p>') !!}
        <span class="help-block">资源路径为路由名称,可以填写路由参数</span>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : '保存', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('rbac.permission.index' , Request::route('role')) }}" class="btn btn-primary">返回列表</a>
    </div>
</div>
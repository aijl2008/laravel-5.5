<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', '菜单名称', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        <p class="help-block">当菜单名称的值为"divider"时，表示一个分隔线</p>
    </div>
</div>
<div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
    {!! Form::label('url', '资源路径', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::text('url', null, ['class' => 'form-control']) !!}
        {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
        <p class="help-block">URL路径必须以"/"为结尾，否则视为路由名，支持"###"做为锚点</p>
    </div>
</div>
<div class="form-group {{ $errors->has('ico') ? 'has-error' : ''}}">
    {!! Form::label('ico', '图标(选填)', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::text('ico', null, ['class' => 'form-control']) !!}
        {!! $errors->first('ico', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('target') ? 'has-error' : ''}}">
    {!! Form::label('target', '目标窗口(选填)', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::text('target', null, ['class' => 'form-control']) !!}
        {!! $errors->first('target', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('order_no') ? 'has-error' : ''}}">
    {!! Form::label('order_no', '显示顺序', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::number('order_no', null, ['class' => 'form-control']) !!}
        {!! $errors->first('order_no', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', '状态', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::select('status', ['1' => '正常', '0' => '无效'], isset($menu->status)?$menu->status:1) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : '保存', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('rbac.menu.index' , Request::route('parent')) }}" class="btn btn-primary">返回列表</a>
    </div>
</div>
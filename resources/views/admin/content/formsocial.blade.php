<?php
$required = "required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('title') !!}
    {!! Form::text('title', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('code') !!}
    {!! Form::text('code', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('url') !!}
    {!! Form::text('body', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-flat">Save</button>
<a href="{{url('admin/content?type=social   ')}}" class="btn btn-default btn-flat">Back</a>
</div>


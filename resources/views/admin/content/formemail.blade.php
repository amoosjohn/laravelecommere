<?php
$required="required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('title') !!}<span class="required">*</span>
    {!! Form::text('title', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('code') !!}<span class="required">*</span>
    {!! Form::text('code', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('subject') !!}<span class="required">*</span>
    {!! Form::text('subject', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('body') !!}<span class="required">*</span>
    {!! Form::textarea('body', null, ['size' => '105x25','class' => 'form-control ckeditor',$required]) !!} 
</div>
<div class="form-group">
    <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
    <a href="{{ url('admin/content?type='.$type)}}" class="btn btn-outline grey-salsa">Cancel</a>
</div>
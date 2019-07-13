<?php
$size = Config::get('params.best_image_size') ;
$required = "required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('First Name') !!}
    <span class="required"> * </span>
    {!! Form::text('firstName', null, array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Last Name') !!}
    {!! Form::text('lastName', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group">
    {!! Form::label('email') !!}
    <span class="required"> * </span>
    {!! Form::email('email', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Password') !!}
    <span class="required"> * </span>
    {!! Form::password('password' , array('class' => 'form-control',(!isset($model))?$required:'') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Confirm Password') !!}
    <span class="required"> * </span>
    {!! Form::password('password_confirmation' , array('class' => 'form-control',(!isset($model))?$required:'') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Status') !!}
    <span class="required"> * </span>
    {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}
   
</div>
<div class="clearfix"></div>

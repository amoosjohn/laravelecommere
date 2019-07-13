<?php
$required="required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('Name') !!}
    {!! Form::text('name', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('category') !!}
    {!! Form::select('categories', $categories,'',['class' => 'form-control','name'=>'category_id']) !!}
</div>
<div class="form-group">
    {!! Form::label('url') !!}
    {!! Form::text('url', null , array('class' => 'form-control',$required) ) !!} 
</div>
<div class="form-group">
    {!! Form::label('teaser') !!}
    {!! Form::text('teaser', null , array('class' => 'form-control',$required) ) !!} 
</div>

<div class="form-group">
    {!! Form::label('description') !!}
    {!! Form::textarea('description', null, ['size' => '105x3','class' => 'form-control ckeditor',$required]) !!} 
</div>

<div class="form-group">
    {!! Form::label('keywords') !!}
    {!! Form::text('keywords', null , array('class' => 'form-control') ) !!} 
</div>

<div class="form-group">
    {!! Form::label('Meta Description') !!}
    {!! Form::text('metaDescription', null , array('class' => 'form-control') ) !!} 
</div>
<div class="form-group">
    {!! Form::label('tags') !!}
    {!! Form::text('tags', null , array('class' => 'form-control',$required) ) !!} 
</div>
<div class="form-group">
    {!! Form::label('image') !!}
    {!! Form::file('image', null, 
    array('class'=>'form-control')) !!}
</div>
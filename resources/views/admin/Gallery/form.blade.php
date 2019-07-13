<?php
$size = Config::get('params.best_image_size');
$required = "required";
//$required = "";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('Title') !!}<span class='red'>*</span>
    {!! Form::text('title', null , array('class' => 'form-control',$required) ) !!}
</div>

<div class="form-group">
    {!! Form::label('Description') !!}<span class='red'>*</span>
    {!! Form::text('description', null , array('class' => 'form-control',$required) ) !!}
</div>

<div class="form-group">
    {!! Form::label('gallery image *') !!}
    {!! Form::file('image', null,array('class'=>'form-control')) !!}
<!--    Best Image Size(<?php echo $size; ?>)-->
</div>
<br clear='all'/>


<div class="form-group">
    <div class="col-sm-4">
        <button type="submit" value="games" class="btn btn-primary btn-block btn-flat">Save</button>
    </div>
    <div class="col-sm-4">
        <a href="{{ url('admin/galleries')}}" class="btn btn-warning btn-block btn-flat">Cancel</a>
    </div>
</div>
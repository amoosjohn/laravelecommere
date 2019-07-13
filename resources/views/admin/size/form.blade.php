<?php
$required = "required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('Name*') !!}
    {!! Form::text('name', null , array('class' => 'form-control',$required) ) !!}

</div>
<div class="form-group">
    {!! Form::label('Status*') !!}
    {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}
   
</div> 
<div class="clearfix"></div>

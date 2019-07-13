<?php
$required = "required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('Code') !!}<span class="required"> * </span>
    {!! Form::text('code', null , array('class' => 'form-control','maxlength' => '20',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Type') !!}<span class="required"> * </span>
    {!! Form::select('type', $types,null , array('class' => 'form-control',$required) ) !!}  
</div>
<div class="form-group">
    {!! Form::label('Amount/Percentage') !!}<span class="required"> * </span>
    {!! Form::number('amount', null , array('class' => 'form-control','min' => '1',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Status') !!}<span class="required"> * </span>
    {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}  
</div>
<div class="form-group">
    {!! Form::label('Start Date') !!}<span class="required"> * </span>
    {!! Form::text('startDate', null , array('class' => 'form-control form-control-inline date-picker','id' => 'startDate','data-date-format' => 'yyyy-mm-dd','data-date-start-date' => '+0d',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('End Date') !!}<span class="required"> * </span>
    {!! Form::text('endDate', null , array('class' => 'form-control form-control-inline date-picker','id' => 'endDate','data-date-format' => 'yyyy-mm-dd','data-date-start-date' => '+0d',$required) ) !!}
</div>
<div class="form-group">
  {!! Form::label('minimum Order Allowed') !!} 
  {!! Form::text('minOrder', null , array('class' => 'form-control') ) !!} 
</div>
<div class="form-group">
    {!! Form::label('Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','size' => '4x4']) !!} 
</div>
<script>
    $("#startDate,#endDate").keydown(function(event) { 
      return false;
    });  
</script>

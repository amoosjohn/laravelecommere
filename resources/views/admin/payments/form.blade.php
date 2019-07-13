<?php
$required = "required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('Vendor') !!}<span class="required"> * </span>
    {!! Form::select('user_id', $users,null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Payment Method') !!}<span class="required"> * </span>
    {!! Form::select('method', $methods,null , array('class' => 'form-control','id' => 'method',$required) ) !!}  
</div>
<div class="form-group" id="account" style="display: none;">
   <label>Transaction/Cheque No.</label>
  {!! Form::text('number', null , array('class' => 'form-control') ) !!} 
</div>
<div class="form-group">
    {!! Form::label('Amount') !!}<span class="required"> * </span>
    {!! Form::number('amount', null , array('class' => 'form-control','min' => '1',$required) ) !!}
</div>
<!--<div class="form-group">
    {!! Form::label('Status') !!}<span class="required"> * </span>
    {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}  
</div>-->
<div class="form-group">
    {!! Form::label('Date of Payment') !!}<span class="required"> * </span>
    {!! Form::text('date', null , array('class' => 'form-control form-control-inline date-picker','id' => 'date','data-date-format' => 'yyyy-mm-dd',$required) ) !!}
</div>
<div class="form-group">
  {!! Form::label('Received by') !!} 
  {!! Form::text('receivedBy', null , array('class' => 'form-control') ) !!} 
</div>
<script>
    @if(isset($model))
        checkAccount(<?php echo $model->method;?>);
    @endif    
    $("#date").keydown(function(event) { 
      return false;
    });  
    $("#method").change(function(event) { 
      checkAccount($(this).val())
    });
    function checkAccount(account) {
      if(account=='2' || account=='3') 
      {
          $("#account").show();
      }
      else {
          $("#account").hide();
      }
    }
    
</script>

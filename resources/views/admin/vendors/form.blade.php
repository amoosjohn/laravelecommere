<?php
$required = "required";
?>
<h4 align="center">Vendor Details</h4>
<div class="form-group">
    {!! Form::label('Company Name') !!}<label style="color:red;">*</label>
    {!! Form::text('firstName', null , array('class' => 'form-control',$required) ) !!}
</div>

<div class="form-group">
    {!! Form::label('email') !!}<label style="color:red;">*</label>
    {!! Form::email('email', null , array('class' => 'form-control',$required) ) !!}
</div>

<div class="form-group">
    {!! Form::label('password') !!}<label style="color:red;">{{ isset($model)?'':'*'}}</label>
    {!! Form::password('password' , array('class' => 'form-control',(isset($model))?'':$required) ) !!}
</div>

<div class="form-group">
    {!! Form::label('confirm password') !!}<label style="color:red;">{{(isset($model))?'':'*'}}</label>
    {!! Form::password('password_confirmation' , array('class' => 'form-control',(isset($model))?'':$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Status*') !!}
    {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}
   
</div>
<div class="form-group">
    {!! Form::label('address') !!}<label style="color:red;">*</label>
    {!! Form::text('address', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Region') !!}<label style="color:red;">*</label>
    {!! Form::select('region', $regions,null , array('class' => 'form-control','id' => 'region',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('city') !!}<label style="color:red;">*</label>
    <select class="form-control" name="city" id="city" <?php echo $required ?>>
        <option value="">Select City*</option>
    </select> 
</div>
<div class="form-group">
    {!! Form::label('postal_code') !!}<label style="color:red;">*</label>
    {!! Form::text('postal_code', null , array('class' => 'form-control',$required) ) !!}
</div>

<div class="form-group">
    {!! Form::label('mobile') !!}<label style="color:red;">*</label>
    {!! Form::number('mobile', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('logo') !!}
    {!! Form::file('logo', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Contact Person') !!}
    {!! Form::text('contactPerson', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Designation') !!}
    {!! Form::text('designation', null , array('class' => 'form-control') ) !!}
</div>

<script>
    $(document).ready(function () {
        $(".select").select();
    });
@if(isset($model))
    getCities('{{ $model->region }}','{{ $model->city }}');
@endif    
function getCities(id,city='')
{
var send = 'region=' + id;
if(city!='')
{
    var send = 'region=' + id + '&city=' + city;
}
$.ajax({
        type: "GET",
        url: "{{ url('checkout/cities') }}",
        data: send,
        success: function(response){
        $('#city').html(response);
        },
        error: function(errormessage) {
        //you would not show the real error to the user - this is just to see if everything is working
        
        }
});
}
$("body").on("change","#region",function(){
    var region = $(this).val();
    getCities(region);
});
</script>
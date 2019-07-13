<?php
$required = "required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('First Name') !!}
    {!! Form::text('firstName', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Last Name') !!}
    {!! Form::text('lastName', null , array('class' => 'form-control',$required) ) !!}
</div>

<div class="form-group">
    {!! Form::label('email') !!}
    {!! Form::text('email', null , array('class' => 'form-control') ) !!}
</div>

<div class="form-group">
    {!! Form::label('password') !!}
    {!! Form::text('password', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group">
    {!! Form::label('confirm password') !!}
    {!! Form::text('password_confirmation', null , array('class' => 'form-control') ) !!}
</div>

<div class="form-group">
    <div class="col-sm-4">
        <input type="hidden" name="role_id" value="1">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
    </div>
    <div class="col-sm-4">
        <a href="{{ url('admin/admin-users')}}" class="btn btn-warning btn-block btn-flat">Cancel</a>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".select").select2();
    });
</script>
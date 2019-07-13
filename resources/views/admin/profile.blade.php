@extends('admin/admin_template')

@section('content')
<?php
$required = "required";
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <div class="portlet-body">
                @include('admin/commons/errors')
                {!! Form::model($model, ['files' => true,'class' => 'form','url' => ['admin/password/update'], 'method' => 'post']) !!}
               
                <div class="form-group">
                    {!! Form::label('old password') !!} <label style="color:red;">*</label>
                    {!! Form::password('old_password' , array('class' => 'form-control',$required)) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('new password') !!} <label style="color:red;">*</label>
                    {!! Form::password('password' , array('class' => 'form-control',$required)) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('confirm password') !!} <label style="color:red;">*</label>
                    {!! Form::password('password_confirmation' , array('class' => 'form-control',$required )) !!}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
                    <a href="{{ url('admin/dashboard')}}" class="btn btn-outline grey-salsa">Back</a>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection
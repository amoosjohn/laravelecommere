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
      <div class="box box-warning">
      
        <div class="box-header with-border">
          <h3 class="box-title">Add New Vendor</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        @include('admin/commons/errors')

          {!! Form::open(array( 'class' => 'form','url' => 'admin/vendor/store', 'files' => true)) !!}
            <!-- text sinput -->
            
            
            @include('admin.vendors.form')
            <!--<h4 align="center">Contact Person Details</h4>
            <div class="form-group">
                {!! Form::label('first name') !!}
                {!! Form::text('contactName', null , array('class' => 'form-control',$required) ) !!}
            </div>
            
            <div class="form-group">
                {!! Form::label('email') !!}<label style="color:red;">*</label>
                {!! Form::email('contactemail', null , array('class' => 'form-control',$required) ) !!}
            </div>
            
            <div class="form-group">
                 {!! Form::label('adress') !!}
                 {!! Form::text('contactaddress', null , array('class' => 'form-control') ) !!}
            </div>
            
            <div class="form-group">
                 {!! Form::label('Mobile') !!}
                {!! Form::number('contactmobile', null , array('class' => 'form-control') ) !!}
            </div>
            
            -->
            
                
             <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                    <a href="{{ url('admin/vendors')}}" class="btn btn-outline grey-salsa">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>

@endsection
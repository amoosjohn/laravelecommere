@extends('admin/admin_template')
<?php
$required = "required";
?>
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Add New User</h3>
            </div>
      
            <!-- /.box-header -->
            <div class="box-body">
            {!! Form::open(array( 'class' => 'form','url' => 'admin/users', 'files' => true)) !!}
               <?php $page='admin.users.form'?>
               @include($page)    
              <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                    <a href="{{ url('admin/users')}}" class="btn btn-outline grey-salsa">Cancel</a>
            </div>
             {!! Form::close() !!}
                
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection
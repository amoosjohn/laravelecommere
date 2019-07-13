@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      
      <!-- /.box -->
      <!-- general form elements disabled -->
      <div class="box box-warning">
      
        <div class="box-header with-border">
          <h3 class="box-title">Add New Admin-User</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(array( 'class' => 'form','url' => 'admin/admin-users/store', 'files' => true)) !!}
            <!-- text input -->
            
            @include('admin.admin-users.form')
            {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>

@endsection
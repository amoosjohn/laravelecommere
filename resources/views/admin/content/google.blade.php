@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      
      <!-- /.box -->
      <!-- general form elements disabled -->
      <div class="box box-warning">
      @if (Session::has('success'))
		<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success !</h4>
            {!! session('success') !!}
        </div>
		@endif
        <div class="box-header with-border">
          <h3 class="box-title">Google Analytics</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::model($model, ['files' => true,'class' => 'form','url' => ['admin/content/google/update', $model->id], 'method' => 'post']) !!}
            <!-- text input -->
            <?php
            $required = "required";
            ?>
            <div class="form-group">
                {!! Form::label('title') !!}
                {!! Form::text('title', null , array('class' => 'form-control',$required) ) !!}
            </div>
            <div class="form-group">
                {!! Form::label('script') !!}
                {!! Form::textarea('body', null, ['size' => '105x15','class' => 'form-control',$required]) !!} 
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-flat">Update</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>

@endsection
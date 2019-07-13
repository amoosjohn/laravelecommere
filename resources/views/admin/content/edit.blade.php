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
          <h3 class="box-title">Edit Content</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::model($model, ['files' => true,'class' => 'form','url' => ['admin/content/update', $model->id], 'method' => 'post']) !!}
            <!-- text input -->
            <?php $page='admin.content.form'.$model->type;?>
            @include($page)
            {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>

@endsection
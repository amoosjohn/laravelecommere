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
          <h3 class="box-title">Add New Content</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(array( 'class' => 'form','url' => 'admin/content/insert', 'files' => true)) !!}
            <?php $page='admin.content.form'.$type;?>
            @include($page)
            <input type="hidden" id="type" name="type" value="<?php echo $type;?>" >
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>

@endsection
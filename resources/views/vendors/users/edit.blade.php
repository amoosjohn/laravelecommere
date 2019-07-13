@extends('vendors/vendor_template')
<?php
$size = Config::get('params.best_image_size') ;
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
                <h3 class="box-title">Update User</h3>
            </div>
      
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::model($model, ['files' => true,'class' => 'form','url' => ['vendor/users/update', $model->id], 'method' => 'post']) !!}
                @include('vendors.users.form')  

                <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
                    <a href="{{ url('vendor/users')}}" class="btn btn-outline grey-salsa">Cancel</a>
                </div>       
                {!! Form::close() !!}
        </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
</section>

<script>
    $('.show_change_pass').on('click',function(e){
        e.preventDefault();
        $('.change_password').toggle();
    });
    
</script>
@endsection

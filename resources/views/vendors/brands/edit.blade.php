@extends('vendors/vendor_template')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Brand</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::model($model, ['files' => true,'class' => 'form','url' => ['vendor/brands/update', $model->id], 'method' => 'post']) !!}

                @include('admin.brands.form')
                <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
                    <a href="{{ url('vendor/brands')}}" class="btn btn-outline grey-salsa">Cancel</a>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection
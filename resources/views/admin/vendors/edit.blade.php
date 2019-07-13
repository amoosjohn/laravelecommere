@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Vendor</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                 @include('admin/commons/errors')
                {!! Form::model($model, ['class' => 'form','url' => ['admin/vendor/update', $model->id], 'method' => 'post','files' => true]) !!}

                @include('admin.vendors.form') 
                <div class="form-group">
   
                    
            <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                    <a href="{{ url('admin/vendors')}}" class="btn btn-outline grey-salsa">Cancel</a>
            </div>
</div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
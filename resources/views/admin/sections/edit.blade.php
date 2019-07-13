@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Section</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::model($model, array('route' => array('sections.update', $model->id), 'method' => 'PUT','files' => true)) !!}

                @include('admin.sections.form')
                <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
                    <a href="{{ url('admin/sections')}}" class="btn btn-outline grey-salsa">Cancel</a>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection
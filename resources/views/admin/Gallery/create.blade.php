@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Add New Gallery</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::open(array( 'class' => 'form','url' => 'admin/gallery/insert','files' => true)) !!}
               
                @include('admin.Gallery.form')
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
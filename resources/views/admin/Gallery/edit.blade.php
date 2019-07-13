@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Gallery</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::model($model, ['class' => 'form','url' => ['admin/gallery/update', $model->id], 'method' => 'post','files' => true]) !!}

                @include('admin.Gallery.form')      
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
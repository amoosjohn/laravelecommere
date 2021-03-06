@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Category</h3>
            </div>
            <!-- /.box-header -->
            @include('admin/commons/errors')
            <div class="box-body">
                {!! Form::model($category, ['files' => true,'class' => 'form','url' => ['admin/categories/update', $category->id], 'method' => 'post']) !!}

                @include('admin.categories.form')
                {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection
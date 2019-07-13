@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-md-10">
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
                <h3 class="box-title">Add New Category</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::open(array( 'class' => 'form','url' => 'admin/categories/storeSubcat', 'files' => true)) !!}
                <div class="form-group">
                    {!! Form::label('Parent Category') !!}
                    {!! Form::select('parent_id', $categories,null,array('class' => 'form-control','required')) !!}
                </div>
                <!-- text input -->
                <div class="form-group">
                    {!! Form::label('Name') !!}
                    {!! Form::text('name', null , array('class' => 'form-control','required') ) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('teaser') !!}
                    {!! Form::textarea('teaser', null, ['size' => '105x3','class' => 'form-control']) !!} 

                </div>

                <div class="form-group">
                    {!! Form::label('url') !!}
                    {!! Form::text('url', null , array('class' => 'form-control','required') ) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('image') !!}
                    {!! Form::file('image', null, 
                    array( 'class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
                </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection
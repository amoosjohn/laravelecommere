@extends('admin/admin_template')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success !</h4>
                {!! session('success') !!}
            </div>
            @endif
            <div class="box-header with-border">
                <h3 class="box-title">Add New Post</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::open(array( 'class' => 'form','url' => 'admin/blog/posts/insert', 'files' => true)) !!}
                @include('admin.blog.posts.form')
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
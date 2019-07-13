@extends('admin/admin_template')
@section('content')
<!-- Main row -->
<h1 class="page-title">Categories</h1>
<div class="row">
<div class="col-md-12">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><i class="icon fa fa-check"></i> &nbsp  {!! session('success') !!}</p>
        </div>
    @endif
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-social-dribbble font-green"></i>
                <span class="caption-subject font-green bold uppercase"> Total Categories : {{ $categories->total() }}  </span>
            
            </div>
             <div class="btn-group pull-right">
                <a href="{{ url('admin/categories/create') }}" class="btn sbold green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            </div>
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
                <table class="table table-hover">
                    <thead>
                        <tr>
                           <th>Name</th>
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($categories)>0)
                        @foreach($categories as $item)
                                <tr>
                                    <td>
                                        <a href="{{url('admin/categories/show/'. $item->id)}}">
                                            <?php
                                            echo ($item->parentName != '') ? $item->parentName . ' <strong>></strong> ' : '';
                                            echo ($item->categoryName != '') ? $item->categoryName . ' <strong>></strong> ' : '';
                                            ?> 
                                            <small>{{ $item->name }}</small></a>

                                    </td>
                                    <td>
                                        @if($item->level==1)
                                        <a href="{{ url('main/' . $item->key) }}" class="btn dark btn-sm" title="View this brand product on site" target="_blank"><i class="fa fa-globe"></i></a>
                                        @else
                                        <a href="{{ url('category/' . $item->key) }}" class="btn dark btn-sm" title="View this brand product on site" target="_blank"><i class="fa fa-globe"></i></a>

                                        @endif
                                        <a href="<?php echo url('admin/categories/edit/' . $item->id); ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                        </a>
                                        <a data-href="<?php echo url('admin/categories/delete/' . $item->id); ?>" data-target="#confirm-delete" class="btn btn-danger btn-sm delete"  data-toggle="modal" title="Delete"><i class="fa fa-trash"></i> </a>

                                    </td>
                                </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="2" class="text-center">Data not found!</td>
                           
                        </tr>
                        @endif
                    </tbody>
                </table>
        <?php echo $categories->render(); ?>   
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                        </div>

                        <div class="modal-body">
                            <p>Are you sure to delete this category?</p>
                        </div>

                        <div class="modal-footer">
                            <a class="btn btn-danger btn-ok" id="btn-ok">Delete</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
       
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>
</div>
<!-- /.row -->
@endsection
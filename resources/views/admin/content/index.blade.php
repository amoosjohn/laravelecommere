@extends('admin/admin_template')
@section('content')
<?php
use App\Functions\Functions;
?>
<!-- Main row -->
<h1 class="page-title" style="text-transform: capitalize;">{{$type}}</h1>
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
                <span class="caption-subject font-green bold uppercase"> Total {{$type}} : {{ $model->total() }}  </span>
            
            </div>
             <div class="btn-group pull-right">
                <a href="{{ url('admin/content/create?type='.$type) }}" class="btn sbold green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            </div>
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
                <table class="table table-hover" data-toggle="dataTable" data-form="deleteForm">
                    <thead>
                        <tr>
                            <th style="width:  20%;"> Title </th>
                            <th style="width:  20%;"> Code </th>
                            <th style="width:  20%;"> Type </th>
                            <th style="width:  20%;"> Created Date </th>
                            <th style="width:  20%;"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($model)>0)
                        @foreach($model as $row)
                        <tr>
                            <td>{{ $row->title }}</td>
                            <td>{{ $row->code }}</td>
                            <td>{{ $row->type }}</td>
                            <td>{{ Functions::frontDate($row->created_at)}}</td>
                            <td>
                                @if($type=='page')
                                <a href="{{ url('/' . $row->code) }}" class="btn dark btn-sm" title="View this page on site" target="_blank"><i class="fa fa-globe"></i></a>
                                @endif
                                <a href="<?php echo url('admin/content/edit/' . $row->id); ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                </a>
                                @if($type=='page')
                                <a data-href="<?php echo url('admin/content/delete/' . $row->id); ?>" data-target="#confirm-delete" class="btn btn-danger delete btn-sm"  data-toggle="modal" title="Delete"><i class="fa fa-trash"></i> </a>
                               @endif
                            </td>
                            
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center">Data not found!</td>
                           
                        </tr>
                        @endif
                    </tbody>
                </table>
        <?php echo $model->render(); ?>   
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this content?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok" id="btn-ok">Delete</a>
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
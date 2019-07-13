@extends('vendors/vendor_template')
@section('content')
<!-- Main row -->
<h1 class="page-title">Brands</h1>
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
                <span class="caption-subject font-green bold uppercase"> Total Brands : {{ $model->total() }}  </span>
            
            </div>
            <div class="btn-group pull-right">
                <a href="{{ url('vendor/brands/create') }}" class="btn sbold green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            </div>
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th> Image </th>
                            <th> Name </th>
                            <th> Status </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($model)>0)
                        @foreach($model as $row)
                        <?php
                            $status = '';
                            $color = '';
                            if (array_key_exists($row->status, $statuses)) {
                               $status = $statuses[$row->status];
                            }
                            if (array_key_exists($row->status, $colors)) {
                               $color = $colors[$row->status];
                            }
                        ?>
                        <tr>
                            <td><img src="{{ asset('/'.$row->image) }}" class="img-responsive" style="width:100px;height:100px"/></td>
                            <td>{{ $row->name }}</td>
                            <td class="{{ $color }} sbold"><i class="fa fa-circle"></i> {{ $status }}</td>
                            <td>
                                <a href="<?php echo url('vendor/brands/edit/' . $row->id); ?>" class="btn btn-primary"><i class="fa fa-edit"></i>
                                </a>
                               <a data-href="<?php echo url('vendor/brands/delete/' . $row->id); ?>" data-target="#confirm-delete" class="btn btn-danger delete"  data-toggle="modal" title="Delete"><i class="fa fa-trash"></i> </a>

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
                        <p>Are you sure to delete this brand?</p>
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

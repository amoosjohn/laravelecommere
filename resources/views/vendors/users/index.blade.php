@extends('vendors/vendor_template')
@section('content')
<!-- Main row -->
<h1 class="page-title">Vendor's Users</h1>
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
                <span class="caption-subject font-green bold uppercase"> Total Users : {{$model->total()}}  </span>
            
            </div>
            @can('product_create')
            <div class="btn-group pull-right">
                <a href="{{ url('vendor/users/create') }}" class="btn sbold green"> Add New User
                <i class="fa fa-plus"></i>
            </a>
            @endcan    
            </div>
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
               
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Mobile No</th>
                            <th>Status</th>
                            <th>Created date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                         @if(count($model))
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
                            <td>{{$row->firstName}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->gender}}</td>
                            <td>{{date('d/m/Y',strtotime($row->dob))}}</td>
                            <td>{{$row->mobile}}</td>
                            <td class="{{ $color }} sbold"><i class="fa fa-circle"></i> {{ $status }}</td>
                            <td><?php echo date("d M Y", strtotime($row->created_at)); ?></td>
                            <td>
                                <a href="<?php echo url('vendor/users/edit', $row->id); ?>" class="btn btn-primary btn-sm" title="Update"><i class="fa fa-edit"></i>
                                </a>
                                <a data-href="<?php echo url('vendor/users/delete/' . $row->id); ?>" data-target="#confirm-delete" class="btn btn-danger btn-sm delete"  data-toggle="modal" title="Delete"><i class="fa fa-trash"></i> </a>


                            </td>
                        </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Data not found!</td>

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
                        <p>Are you sure to delete this vendor user?</p>
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
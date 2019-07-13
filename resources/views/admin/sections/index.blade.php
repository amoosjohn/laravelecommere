@extends('admin/admin_template')
@section('content')
<!-- Main row -->
<h1 class="page-title">Sections</h1>
<div class="row">
<div class="col-md-12">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><i class="icon fa fa-check"></i> &nbsp  {!! session('success') !!}</p>
        </div>
    @endif
    <!--BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-social-dribbble font-green"></i>
                <span class="caption-subject font-green bold uppercase"> Total Sections : {{ $model->total() }}  </span>
            </div>
            <div class="btn-group pull-right">
                <a href="{{ url('admin/sections/create') }}" class="btn sbold green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
                <table class="table table-hover" data-toggle="dataTable" data-form="deleteForm">
                    <thead>
                        <tr>
                            <th> Image </th>
                            <th> Category </th>
                            <th> Section Type </th>
                            <th> Created By</th>
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
                            $type = '';
                            if (array_key_exists($row->status, $statuses)) {
                               $status = $statuses[$row->status];
                            }
                            if (array_key_exists($row->status, $colors)) {
                               $color = $colors[$row->status];
                            }
                            if (array_key_exists($row->type, $types)) {
                               $type = $types[$row->type];
                            }
                        ?>
                        <tr>
                            <td>
                                <img src="{{ ($row->image!='')?asset('/'.$row->image):'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image' }}" class="img-responsive" style="width:100px;height:100px"/>
                            </td>
                            <td>{{ (count($row->categories)>0)?$row->categories->name:'' }}</td>
                            <td>{{ $type }}</td>
                            <td>{{ (count($row->users)>0)?$row->users->firstName:'' }}</td>
                            <td class="{{ $color }} sbold"><i class="fa fa-circle"></i> {{ $status }}</td>
                            <td>
                                <a href="<?php echo url('admin/sections/'.$row->id.'/edit'); ?>" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i>
                                </a>
                                {!! Form::open(array('url' => 'admin/sections/' .$row->id,'class'=>'form-inline form-delete','id'=>'delete')) !!}
                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    <button type="submit" name="delete_modal" class="btn btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </button>

                                {!! Form::close() !!}
                              
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center">Data not found!</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
        <?php echo $model->render(); ?>        
        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this sections?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete-btn">Delete</button>
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

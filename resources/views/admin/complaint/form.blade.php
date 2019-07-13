<?php
use App\Functions\Functions;
$required = "required";
?>
@include('admin/commons/errors')
<div class="portlet-body">
    <div class="tabbable-line">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">

                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="portlet blue-hoki box">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-cogs"></i>Complaint Details </div>

                            </div>
                            
                            <div class="portlet-body">
                                <div class="row static-info">
                                    <div class="col-md-5 name">Complaint No. : </div>
                                    <div class="col-md-7 value">{{ $model->id }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Customer Name: </div>
                                    <div class="col-md-7 value">{{ $model->name }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Email: </div>
                                    <div class="col-md-7 value">{{ $model->email }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Contact No. : </div>
                                    <div class="col-md-7 value">{{ $model->contact }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Address: </div>
                                    <div class="col-md-7 value">{{ $model->address }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Type: </div>
                                    <div class="col-md-7 value">{{ $model->type }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Details: </div>
                                    <div class="col-md-7 value">{{ $model->details }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Date: </div>
                                    <div class="col-md-7 value"> {{ Functions::frontDate($model->created_at)}} </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Modified By: </div>
                                    <div class="col-md-7 value">{{ (count($model->users)>0)?$model->users->firstName:'' }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Resolved Date:</div>
                                    <div class="col-md-4 value">{!! Form::text('resolvedDate', null , array('class' => 'form-control form-control-inline date-picker','id' => 'resolvedDate','data-date-format' => 'yyyy-mm-dd') ) !!}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Status: </div>
                                    <div class="col-md-4 value">
                                        {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Comments: </div>
                                    <div class="col-md-7 value">{!! Form::textarea('comments', null, ['class' => 'form-control','size' => '4x8']) !!} </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>   
</div>
<script>
    $("#resolvedDate").keydown(function(event) { 
      return false;
    });  
</script>
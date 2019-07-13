@extends('admin/admin_template')
@section('content')
<?php
use App\Functions\Functions;
?>
<!-- Main row -->
<h1 class="page-title">Customer Details</h1>
<div class="row">
<div class="col-md-12">
   @include('admin.commons.errors') 
    <!-- Begin: life time stats -->

    <div class="portlet light portlet-fit portlet-datatable bordered">
        <div class="portlet-title">
            <div class="caption">
                <button type="button" onClick="window.location ='{{ url('admin/customers')}}';" class="btn btn-secondary-outline">
                    <i class="fa fa-angle-left"></i> Back</button>
            </div>
        </div>
        
        <div class="portlet-body">
            <div class="tabbable-line">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        
                        <div class="row">
                            
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet blue-hoki box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>Customer Information </div>
                                       
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> First Name: </div>
                                            <div class="col-md-7 value">{{ $model->firstName }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Last Name: </div>
                                            <div class="col-md-7 value">{{ $model->lastName }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Email: </div>
                                            <div class="col-md-7 value"> {{ $model->email }} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Gender: </div>
                                            <div class="col-md-7 value">{{ $model->gender }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Date of birth: </div>
                                            <div class="col-md-7 value">{{ $model->dob }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Status: </div>
                                            <div class="col-md-7 value">
                                                <span class="{{ $color }} sbold"><i class="fa fa-circle"></i> {{ $status }}
                                                </span></div>
                                        </div>
                                        
                                        
                                       
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet green-meadow box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i> Address </div>
                                        
                                    </div>
<!--                                    {{ $model->guestName." ".$model->guestLast }}-->
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Mobile #: </div>
                                            <div class="col-md-7 value">{{ $model->mobile }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Address: </div>
                                            <div class="col-md-7 value">{{ $model->address }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Region Name: </div>
                                            <div class="col-md-7 value">{{ $model->regionName }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> City Name: </div>
                                            <div class="col-md-7 value"> {{ $model->cityName }} </div>
                                        </div>
                                         <div class="row static-info">
                                            <div class="col-md-5 name"> Registration Date: </div>
                                            <div class="col-md-7 value">{{ date("d M Y", strtotime($model->created_at)) }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Newsletter subscription: </div>
                                            <div class="col-md-7 value">{{ ($model->newsletter==1) ? 'Yes' : 'No' }}</div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="portlet grey-cascade box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="text-center">Total Orders: {{ $orders->total() }}</span>
                                        </div>
                                        
                                    </div>
                                    <div class="portlet-body">
                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%;"> Order # </th>
                                                        <th style="width: 15%;">  Purchased On  </th>
                                                        <th style="width: 10%;"> Total Products </th>
                                                        <th style="width: 15%;"> Grand Total </th>
                                                        <th style="width: 10%;"> Status </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  @if(count($orders)>0)  
                                                  @foreach ($orders as $row)
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
                                                        <td style="width: 10%;"><a title="View Order Details" href="<?php echo url('admin/orders/' . $row->id); ?>" target="_blank">{{ $row->id }}</a></td>
                                                        <td style="width: 15%;"><a title="View Order Details" href="<?php echo url('admin/orders/' . $row->id); ?>" target="_blank">{{ Functions::dateFormat($row->created_at) }}</a></td>
                                                        <td style="width: 10%;">{{ $row->totalQuantity }}</td>
                                                        <td style="width: 15%;">{{ $symbol.".".Functions::moneyFormat($row->grandTotal) }}</td>
                                                        <td style="width: 10%;"><span class="{{ $color }} sbold">{{ $status }}</span></td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    @else 
                                                    <tr>
                                                        <td colspan="6" class="text-center">Data not found!</td>

                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                            <?php echo $orders->appends(Input::except('page'))->links();?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
    </div>
   </div>   
   </div>
           
</div>
{!! Form::close() !!}
</div>
</div>
<!-- /.row -->
@endsection

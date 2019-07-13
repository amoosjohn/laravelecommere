@extends('vendors/vendor_template')
@section('content')
<?php
use App\Functions\Functions;
?>
<!-- Main row -->
<h1 class="page-title">Order View</h1>
<div class="row">
<div class="col-md-12">
   @include('vendors.commons.errors') 
    <!-- Begin: life time stats -->
   {!! Form::model($order, array('url' => 'vendor/orders/'.$order->id, 'method' => 'PUT', 'class' => '','files' => true)) !!}

    <div class="portlet light portlet-fit portlet-datatable bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-settings font-dark"></i>
                <span class="caption-subject font-dark sbold uppercase"> Order #{{ $order->id }}
                    <span class="hidden-xs">| {{ Functions::orderDateFormat($order->created_at)}} </span>
                </span>
            </div>
             <div class="actions btn-set">
                <a href="{{url('vendor/orders/invoice/'.$order->id)}}" target="_blank" class="btn dark btn-outline" tabindex="0" aria-controls="sample_1" >
                <span><i class="fa fa-print"></i> Print Invoice</span></a>
                <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
                <button type="button" onClick="window.location ='{{ url('vendor/orders')}}';" class="btn btn-secondary-outline">
                    <i class="fa fa-angle-left"></i> Back</button>
            </div>
            
        </div>
        <div class="portlet-body">
            <div class="tabbable-line">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet yellow-crusta box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Order Details </div>
                                        
                                    </div>
                                    
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Order #: </div>
                                            <div class="col-md-7 value"> {{ $order->id }}
                                                @if($order->emailConfirmation==1)
                                                <span class="label label-info label-sm"> Confirmation Email  was sent </span>
                                                @else
                                                <span class="label label-danger label-sm">Confirmation Email was not sent</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Order Date & Time: </div>
                                            <div class="col-md-7 value"> {{ Functions::orderDateFormat($order->created_at)}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Vendor Status: </div>
                                            <div class="col-md-7 value">
                                               @if($order->status==1)
                                               {!! Form::select('vendorStatus', $vendorStatus,(isset($products))?$products[0]->vendorStatus:null , array('class' => 'form-control') ) !!}
                                               @else
                                                <?php
                                                $status = '';
                                                $vendor = $products[0]->vendorStatus;
                                                if (array_key_exists($vendor, $vendorStatus)) {
                                                    $status = $vendorStatus[$vendor];
                                                }
                                                echo $status;
                                                ?>
                                               @endif
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Order Status: </div>
                                            <div class="col-md-7 value">
                                                <?php
                                                $status = '';
                                                if (array_key_exists($order->status, $statuses)) {
                                                    $status = $statuses[$order->status];
                                                }
                                                echo $status;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Grand Total: </div>
                                            <div class="col-md-7 value"> {{ $symbol.".".Functions::moneyFormat($order->grandTotal) }} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Payment Information: </div>
                                            <div class="col-md-7 value"> {{ $order->paymentType }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet blue-hoki box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Customer Information </div>
                                       
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Customer Name: </div>
                                            <div class="col-md-7 value">{{ $user->firstName." ".$order->lastName }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Email: </div>
                                            <div class="col-md-7 value"> {{ $user->email }} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Phone Number: </div>
                                            <div class="col-md-7 value"> {{ $user->phone }} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> Region: </div>
                                            <div class="col-md-7 value"> {{ $user->regionName }} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> City: </div>
                                            <div class="col-md-7 value"> {{ $user->cityName }} </div>
                                        </div>
                                        
                                          <div class="row static-info">
                                            <div class="col-md-5 name"> Address: </div>
                                            <div class="col-md-7 value"> {{ $user->address }} </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet green-meadow box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Billing Address </div>       
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-12 value"> 
                                                <?php echo ($order->address!='')?$order->address." ".$order->cityName." ".$order->regionName.", Pakistan":$user->address." ".$user->cityName." ".$user->regionName.", Pakistan";?> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet red-sunglo box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Shipping Address </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-12 value">
                                                <?php
                                                if ($order->shipAddress == '1') {
                                                    echo ($order->address != '') ? $order->address . " " . $order->cityName . " " . $order->regionName . ", Pakistan" : $user->address . " " . $user->cityName . " " . $user->regionName . ", Pakistan";
                                                } else {
                                                    echo $order->shipAddress;
                                                }
                                                ?>                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="portlet grey-cascade box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Shopping Cart </div>
                                        
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th> Image </th>
                                                        <th> Name </th>
                                                        <th> Sku </th>
                                                        <th> Child Sku </th>
                                                        <th> Quantity </th>
                                                        <th> Unit Price </th>
                                                        <th> Total Price </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($products as $product)
                                                    <tr>
                                                        <td>
                                                            <div class="cart__img">
                                                                <img src="{{ asset('/'.$product->url)}}" height="80" alt="{{ $product->name }}" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                        <small class="clearfix">{{ $product->category }}</small>
                                                        <a href="{{ url('vendor/products/'.$product->product_id.'/edit') }}">{{ $product->name }}</a><br/>
                                                        <small>{{ ($product->size!='')?'Size:'.$product->size:'' }}</small>
                                                        </td>
                                                       <td> {{ $product->sku }} </td>
                                                       <td> {{ $product->childSku }} </td>
                                                        <td> {{ $product->quantity }} </td>
                                                        <td> {{ $symbol.".".Functions::moneyFormat($product->unitPrice) }} </td>
                                                        <td> {{ $symbol.".".Functions::moneyFormat($product->totalPrice) }} </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"> </div>
                            <div class="col-md-6">
                                <div class="well">
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name"> Sub Total: </div>
                                        <div class="col-md-3 value"> {{ $symbol.".".Functions::moneyFormat($order->subTotal) }} </div>
                                    </div>
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name"> Discount: </div>
                                        <div class="col-md-3 value"> {{ ($order->discount!='')?"- ".$symbol.".".Functions::moneyFormat($order->discount):$symbol.".0" }}</div>
                                    </div>
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name"> Grand Total: </div>
                                        <div class="col-md-3 value"> {{ $symbol.".".Functions::moneyFormat($order->grandTotal) }} </div>
                                    </div>
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name"> Total Paid: </div>
                                        <div class="col-md-3 value"> {{ ($order->status==5)?$symbol.".".Functions::moneyFormat($order->grandTotal):$symbol.".0" }} </div>
                                    </div>
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name"> Total Refunded: </div>
                                        <div class="col-md-3 value"> {{ ($order->status==11)?$symbol.".".Functions::moneyFormat($order->grandTotal):$symbol.".0" }} </div>
                                    </div>
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name"> Total Due: </div>
                                        <div class="col-md-3 value"> {{ ($order->status!=5 && $order->status!=11)?$symbol.".".Functions::moneyFormat($order->grandTotal):$symbol.".0" }} </div>
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

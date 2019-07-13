@extends('beautymail::templates.widgets')

@section('content')
<?php
use App\Functions\Functions;
?>
@if(isset($print))
<style media="print">
@page {
  size: auto;
  margin: 0;
}

</style>
<script>
window.print();    
</script>
@endif
<table width="100%">
    <tbody>
        <tr>
            <td style="width:50%;">
                @include('beautymail::templates.widgets.articleStart')

                <h2>Order Details</h2>

                <table>
                    <tbody>
                        <tr>
                            <td>Order #: <span>{{ $order->id }}</span></td>
                        </tr>
                        <tr>
                            <td>Order Date & Time: <span>{{ Functions::orderDateFormat($order->created_at)}}</span></td>
                        </tr>
                        @if(!isset($print))
                        <tr>
                            <td>Order Status: <span> {{$status}}</span></td>
                        </tr>
                        @endif
                        <tr>
                            <td>Grand Total: <span> {{ $symbol.".".Functions::moneyFormat($order->grandTotal) }}</span></td>
                        </tr>
                        <tr>
                            <td>Payment Information: <span> {{ $order->paymentType }}</span></td>
                        </tr>
                        @if(isset($print))
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                @include('beautymail::templates.widgets.articleEnd')
            </td>

            <td style="width:50%;">
                @include('beautymail::templates.widgets.newfeatureStart')

                <h2>Customer Information</h2>

                <table>
                    <tbody>

                        <tr>
                            <td>Customer Name: <span>{{ $order->firstName." ".$order->lastName }}</span></td>
                        </tr>
                        <tr>
                            <td>Email: <span>{{ $order->email }}</span></td>
                        </tr>
                        <tr>
                            <td>Phone Number: <span>{{ $order->mobile }}</span></td>
                        </tr>
                        <tr>
                            <td>Region: <span>{{ $order->regionName }}</span></td>
                        </tr>
                        <tr>
                            <td>City: <span>{{ $order->cityName }}</span></td>
                        </tr>
                    </tbody>
                </table>

                @include('beautymail::templates.widgets.newfeatureEnd')
            </td>
        </tr>
    </tbody>
    </table>

<table width="100%">
    <tbody>
        <tr>        
        
      <td style="width:50%;">
                @include('beautymail::templates.widgets.articleStart')

                <h2>Billing Address</h2>

                <table>
                    <tbody>   
                          <tr>
                            <td><?php echo ($order->address!='')?$order->address." ".$order->cityName." ".$order->regionName.", Pakistan":$user->address." ".$user->cityName." ".$user->regionName.", Pakistan";?></td>
                        </tr>
                    </tbody>
                </table>
                 @include('beautymail::templates.widgets.articleEnd')
      </td>
      
      <td style="width:50%;">
                @include('beautymail::templates.widgets.newfeatureStart')

                <h2>Shipping Address</h2>

                <table>
                    <tbody>   
                          <tr>
                              <td><?php
                                  if ($order->shipAddress == '1') {
                                      echo ($order->address != '') ? $order->address . " " . $order->cityName . " " . $order->regionName . ", Pakistan" : $user->address . " " . $user->cityName . " " . $user->regionName . ", Pakistan";
                                  } else {
                                      echo $order->shipAddress;
                                  }
                                  ?></td>
                        </tr>
                    </tbody>
                </table>
                 @include('beautymail::templates.widgets.newfeatureEnd')
      </td>
  </tr>
    </tbody>
    </table>      
        @include('beautymail::templates.widgets.prdt_invoiceStart')

        <h2>Shopping Cart</h2>

        <table style="border:1px solid #eee;" width="100%">

            <thead>
                <tr style="">
                    <th style="text-align:left; border-bottom:1px solid #eee; width:50%; padding:20px;" colspan="3">Name</th>
                    <th style="text-align:left; border-bottom:1px solid #eee; padding:20px;border-left:1px solid #eee;" colspan="3">Sku</th>
                    <th style="text-align:left; border-bottom:1px solid #eee; padding:20px;border-left:1px solid #eee;" colspan="3">Child Sku</th>
                    <th style="text-align:left; border-bottom:1px solid #eee; padding:20px;border-left:1px solid #eee;" colspan="3">Quantity</th>
                    <th style="text-align:left; border-bottom:1px solid #eee; padding:20px;border-left:1px solid #eee;" colspan="3">Unit Price</th>
                    <th style="text-align:left; border-bottom:1px solid #eee; padding:20px;border-left:1px solid #eee;" colspan="3">Total Price</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td style="text-align:left; width:50%; padding:20px;" colspan="3">
                        <small class="clearfix">{{ $product->category }}</small><br/>
                        {{ $product->name }}<br/>
                    <small>{{ ($product->size!='')?'Size:'.$product->size:'' }}</small>
                    </td>
                    <td style="text-align:left; padding:20px;border-left:1px solid #eee;" colspan="3">{{ $product->sku }}</td>
                    <td style="text-align:left; padding:20px;border-left:1px solid #eee;" colspan="3">{{ $product->childSku }}</td>
                    <td style="text-align:left; padding:20px;border-left:1px solid #eee;" colspan="3">{{ $product->quantity }}</td>
                    <td style="text-align:left; padding:20px;border-left:1px solid #eee;" colspan="3">{{ $symbol.".".Functions::moneyFormat($product->unitPrice) }}</td>
                    <td style="text-align:left; padding:20px;border-left:1px solid #eee;" colspan="3">{{ $symbol.".".Functions::moneyFormat($product->totalPrice) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="cart-total_table" width="100%" style="margin-top:50px;">
            <tbody>
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:30%;"> 
                        <table style="border:1px solid #eee;" width="100%;">
                            <tbody>
                                <tr><td style="border-bottom:1px solid #eee;"><b style="padding:10px;padding-right:10px;width: 200px;display: inline-block;">Sub Total:</b><span style="padding: 10px;border-left: 1px solid #eee;padding-left: 10px;font-weight: bold;">{{ $symbol.".".Functions::moneyFormat($order->subTotal) }}</span></td></tr>
                                <tr><td style="border-bottom:1px solid #eee;"><b style="padding:10px;padding-right:10px;width: 200px;display: inline-block;">Discount</b><span style="padding: 10px;border-left: 1px solid #eee;padding-left: 10px;font-weight: bold;">{{ ($order->discount!='')?$symbol.".".Functions::moneyFormat($order->discount):$symbol.".0" }}</span></td></tr>
                                <tr><td style="border-bottom:1px solid #eee;"><b style="padding:10px;padding-right:10px;width: 200px;display: inline-block;">Shipping:</b><span style="padding: 10px;border-left: 1px solid #eee;padding-left: 10px;font-weight: bold;">{{ ($order->shipping!='')?$symbol.".".Functions::moneyFormat($order->shipping):$symbol.".0" }}</span></td></tr>
                                <tr><td style="border-bottom:1px solid #eee;"><b style="padding:10px;padding-right:10px;width: 200px;display: inline-block;">Grand Total:</b><span style="padding: 10px;border-left: 1px solid #eee;padding-left: 10px;font-weight: bold;">{{ $symbol.".".Functions::moneyFormat($order->grandTotal) }}</span></td></tr>
				<tr><td style="border-bottom:1px solid #eee;"><b style="padding:10px;padding-right:10px;width: 200px;display: inline-block;">Total Paid:</b><span style="padding: 10px;border-left: 1px solid #eee;padding-left: 10px;font-weight: bold;">{{ ($order->status==5)?$symbol.".".Functions::moneyFormat($order->grandTotal):$symbol.".0" }}</span></td></tr>
                                <tr><td style="border-bottom:1px solid #eee;"><b style="padding:10px;padding-right:10px;width: 200px;display: inline-block;">Total Refunded:</b><span style="padding: 10px;border-left: 1px solid #eee;padding-left: 10px;font-weight: bold;">{{ ($order->status==11)?$symbol.".".Functions::moneyFormat($order->grandTotal):$symbol.".0" }}</span></td></tr>

                                <tr><td><b style="padding:10px;padding-right:10px;width: 200px;display: inline-block;">Total Due:</b><span style="padding: 10px;border-left: 1px solid #eee;padding-left: 10px;font-weight: bold;">{{ ($order->status!=5)?$symbol.".".Functions::moneyFormat($order->grandTotal):$symbol.".0" }}</span></td></tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2>Notes</h2>
        <p><?php echo $order->notes;?></p>
        @include('beautymail::templates.widgets.prdt_invoiceEnd')








        @stop


@extends('vendors/vendor_template')
@section('content')
<?php
use App\Functions\Functions;
?>
<!-- Main row -->
<h1 class="page-title">Payments</h1>
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
                <span class="caption-subject font-green bold uppercase"> Total Payments :  {{count($model)}} </span>
            
            </div>
            <div class="actions btn-set">
                <button type="button" onclick="window.location ='{{ url('vendor/report') }}';" class="btn btn-secondary-outline">
                    <i class="fa fa-angle-left"></i> Back</button>
            </div>
           
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
                <table class="table table-hover" data-toggle="dataTable" data-form="deleteForm">
                    <thead>
                        <tr>
                            <th> Vendor Name </th>
                            <th> Amount </th>
                            <th> Payment Method </th>
                            <th> Transaction/Cheque No. </th>
                            <th> Date of Payment  </th>
                            <th> Received By </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($model)>0)
                        @foreach($model as $row)
                        <?php
                            $method = '';
                            if (array_key_exists($row->method, $methods)) {
                               $method = $methods[$row->method];
                            }
                        ?>
                        <tr>
                            <td>{{ (count($row->users)>0)?$row->users->firstName:'' }}</td>
                            <td>{{ $symbol.'.'.Functions::moneyFormat($row->amount) }}</td>
                            <td>{{ $method }}</td>
                            <td>{{ $row->number }}</td>
                            <td>{{ Functions::dateFormat($row->date)}}</td>
                            <td>{{ $row->receivedBy }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center">Data not found!</td>
                           
                        </tr>
                        @endif
                    </tbody>
                </table>
      
       
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>
</div>
<!-- /.row -->
@endsection

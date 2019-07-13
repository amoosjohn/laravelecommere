@extends('admin/admin_template')

@section('content')
<?php 
use App\Functions\Functions;
?>
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach
</div> <!-- end .flash-message -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Small boxes (Stat box) -->
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="{{url('admin/vendors')}}">
                <div class="visual">
                    <i class="fa fa-user-plus"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$totalUsers}}">{{$totalUsers}}</span>
                    </div>
                    <div class="desc">Vendors</div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue-hoki" href="{{url('admin/customers')}}">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$totalCustomers}}">{{$totalCustomers}}</span></div>
                    <div class="desc"> Total Customers </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="{{url('admin/categories')}}">
                <div class="visual">
                    <i class="fa fa-tags"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$totalCategories}}">{{$totalCategories}}</span> </div>
                    <div class="desc">Total Categories</div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="{{url('admin/products')}}">
                <div class="visual">
                    <i class="fa fa-line-chart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$totalProducts}}">{{$totalProducts}}</span>
                    </div>
                    <div class="desc"> Total Products </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="{{url('admin/orders')}}">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$totalOrders}}">{{$totalOrders}}</span></div>
                    <div class="desc"> Total Orders </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red-haze" href="{{url('admin/orders')}}">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$totalPendingOrders}}">{{$totalPendingOrders}}</span></div>
                    <div class="desc"> Total Pending Orders </div>
                </div>
            </a>
        </div>
       <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green-meadow" href="{{url('admin/orders')}}">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$totalSales}}">{{$symbol.' '.Functions::moneyFormat($totalSales)}}</span></div>
                    <div class="desc"> Total Sales </div>
                </div>
            </a>
        </div> 
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red-sunglo" href="{{url('admin/orders')}}">
                <div class="visual">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$totalPending}}">{{$symbol.' '.Functions::moneyFormat($totalPending)}}</span></div>
                    <div class="desc"> Total Pending </div>
                </div>
            </a>
        </div> 

        
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-area-chart font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Monthly sales ({{$year}})</span>
                    </div>
                    <!--                        <div class="actions">
                                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                    <i class="icon-cloud-upload"></i>
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                    <i class="icon-wrench"></i>
                                                </a>
                                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                    <i class="icon-trash"></i>
                                                </a>
                                            </div>-->
                </div>
                <div class="portlet-body">
                    <div id="morris_chart_1" style="height:300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-line-chart font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Monthly orders ({{$year}})</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="morris_chart_2" style="height:300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
   
</section>   
<script src="{{ asset('admins/assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admins/assets/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
<script>
var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

jQuery(document).ready(function(){
new Morris.Area(
{
element:"morris_chart_1",
data:[<?php echo $chartData; ?>],
xkey:"year",ykeys:["total"],
labels:["Sales"],
dateFormat: function(x) {
    var month = months[new Date(x).getMonth()];
    return month;
  },
 xLabelFormat: function(x) { // <--- x.getMonth() returns valid index
   var month = months[x.getMonth()];
    return month;
  },
  

}),
new Morris.Line(
{
element:"morris_chart_2",
data:[<?php echo $chartData2; ?>],
xkey:"year",ykeys:["total"],
labels:["Orders"],
dateFormat: function(x) {
    var month = months[new Date(x).getMonth()];
    return month;
  },
 xLabelFormat: function(x) { // <--- x.getMonth() returns valid index
   var month = months[x.getMonth()];
    return month;
  },
  

})
});
</script>
@endsection
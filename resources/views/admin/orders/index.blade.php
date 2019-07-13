@extends('admin/admin_template')
@section('content')
<style>
.table {
    margin-bottom: 0px;
}
</style>
<!-- Main row -->
<h1 class="page-title">Orders</h1>
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
                <span class="caption-subject font-green bold uppercase"> Total Orders : {{ $model }}  </span>
            
            </div>
            <!--<div class="btn-group pull-right">
                <a href="{{ url('admin/products/create') }}" class="btn sbold green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            </div>-->
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
               <form method="get" id="search" name="search">
                <table class="table table-striped table-bordered  table-checkable  no-footer">
                    <thead>
                        <tr role="row" class="heading">
                            <th style="width: 10%;"> Order # </th>
                            <th style="width: 15%;">  Purchased On  </th>
                            <th style="width: 15%;"> Customer Name </th>
                            <th style="width: 10%;"> Total Products </th>
                            <th style="width: 15%;"> Grand Total </th>
                            <th style="width: 10%;"> V Status </th>
                            <th style="width: 10%;"> Status </th>
                            <th style="width: 10%;"> Action </th>
                        </tr>
                       
                        <tr role="row" class="filter">
                       
                        <td>
                            <input type="number" min="1" class="form-control form-filter input-sm" name="order_id" id="order_id"> </td>
                        <td> 
                            <div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
                            <input type="text" class="form-control form-filter input-sm"  name="date_from" placeholder="From">
                            <span class="input-group-btn">
                                <button class="btn btn-sm default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                        <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                            <input type="text" class="form-control form-filter input-sm"  name="date_to" placeholder="To">
                            <span class="input-group-btn">
                                <button class="btn btn-sm default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                        </td>
                        <td>
                          {!! Form::text('customer', null , array('class' => 'form-control form-filter input-sm') ) !!}
                        <td>
                                
                        </td>
                        
                        
                        <td>
                            <div class="margin-bottom-5">
                            <input type="number" class="form-control form-filter input-sm" min='1' name="price_min" placeholder="From" /> </div>
                            <input type="number" class="form-control form-filter input-sm" max='1' name="price_max" placeholder="To" /> </td>
                        
                        <td>
                          {!! Form::select('vendorStatus', $vendorStatus,null , array('class' => 'form-control form-filter input-sm') ) !!}
     
                        </td>
                        <td>
                            {!! Form::select('status', $statuses,null , array('class' => 'form-control form-filter input-sm') ) !!}

                        </td>
                        <td>
                            
                        </td>
                       
                    </tr>
                    
                    </thead>
                   </table>
                   </form>
                    <div  id="result"></div>
                    <div class="loader text-center" style="display: none;"><i class="fa fa-spin"><img class="img-center" src="<?php echo url('front/images/loading.png');?>" /></i></div>

                  
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>
</div>
<!-- /.row -->
<script>
    $(document).ready(function () {
    searchResult('');
    
    $(function() {
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();

        var url = $(this).attr('href'); 
        var getval = url.split('?');
        var value=getval[1];
        searchResult(value);
        return false;

    });

});
    function searchResult(search)
    {   
        $("#result").html("");
        $('.loader').show();
        $.ajax({
            type: 'GET',
            data: search,
            url: '{{ url("admin/orders/search") }}',
            success: function(data) 
            {
                $('.loader').hide();
                $("#result").html(data);
            }
        });   
    }
    $('#search').on('keyup change', function() {
        var search = $('#search').serialize();
        searchResult(search);
     });
    localStorage.removeItem('selectedTab');  
 });
    
</script>
@endsection

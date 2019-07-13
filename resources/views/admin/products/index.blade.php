@extends('admin/admin_template')
@section('content')
<!-- Main row -->
<h1 class="page-title">Products</h1>
<div class="row">
<div class="col-md-12">
    @include('admin.commons.errors')
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-social-dribbble font-green"></i>
                <span class="caption-subject font-green bold uppercase"> Total Products : {{ $model }}  </span>
            
            </div>
            <!--<div class="btn-group pull-right">
                <a href="{{ url('admin/products/create') }}" class="btn sbold green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            </div>-->
        </div>
        <div class="portlet-body">
          <div class="form-group">
                <a class="btn btn-danger" id="delete">
                <i class="fa fa-trash"></i> Delete Checked</a>
                {!! Form::open(['url' => 'admin/product/massDelete', 'method' => 'post', 'id' => 'massDelete']) !!}
                <input type="hidden" id="send" name="toDelete">
                {!! Form::close() !!}
                </div>
            <div class="table-scrollable">
                

                 <form action="{{url("admin/product/search")}}" method="get" id="search" name="search">
                     <label>Show <select name="length" id="length" class="">
                             <option value="10">10</option>
                             <option value="25">25</option>
                             <option value="50">50</option>
                             <option value="100">100</option>
                         </select> 
                    entries</label>
                <table class="table table-hover">
                    <thead>
                        <tr role="row" class="heading">
                            <th style="width:  3%;"><input type="checkbox" class="mass" name="deleteAll"/></th>
                            <th style="width:  5%;"> ID </th>
                            <th style="width: 8%;"> Image </th>
                            <th style="width: 10%;"> Name </th>
                            <th style="width: 10%;"> Category </th>
                            <th style="width: 8%;"> Brand </th>
                            <th style="width: 8%;"> Price </th>
                            <th style="width: 5%;"> Commission </th>
                            <th style="width: 10%;"> Vendor </th>
                            <th style="width: 5%;"> Status </th>
                            <th style="width: 8%;"> Action </th>
                        </tr>
                       
                        <tr role="row" class="filter">
                        <td></td>
                        <td>
                            <input type="number" class="form-control form-filter input-sm" name="product_id" id="product_id"> </td>
                        <td> </td>
                        <td>
                            <input type="text" class="form-control form-filter input-sm" name="product_name" id="product_name"> </td>
                        <td>
                            <select class="form-control form-filter input-sm" name="category_id" id="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $row)
                                <option value="{{ $row->id }}"><?php echo ($row->parentName!='')?$row->parentName.' <strong>></strong> ':''; 
                                echo ($row->categoryName!='')?$row->categoryName.' <strong>></strong> ':'';?> 
                                {{ $row->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                          {!! Form::select('brand_id', $brands,null , array('class' => 'form-control form-filter input-sm') ) !!}

                        </td>
                        <td>
                            <div class="margin-bottom-5">
                            <input type="number" class="form-control form-filter input-sm" min='1' name="price_min" placeholder="From" /> </div>
                            <input type="number" class="form-control form-filter input-sm" max='1' name="price_max" placeholder="To" /> </td>
                        
                        <td></td>
                        <td>
                          {!! Form::select('created_by', $users,null , array('class' => 'form-control form-filter input-sm') ) !!}

                        </td>
                        
                        <td>
                            {!! Form::select('status', $statuses,null , array('class' => 'form-control form-filter input-sm') ) !!}

                        </td>
                        <td>
<!--                            <button type="button" id="button-filter" class="btn btn-default">
                                <i class="fa fa-filter"></i>
                                Search
                            </button>  -->
                        </td>
                    </tr>
                    
                    </thead>
                   </table>
                   </form>
                    <div  id="result">
                        
                    </div>
                <div class="loader text-center" style="display: none;"><i class="fa fa-spin"><img class="img-center" src="<?php echo url('front/images/loading.png');?>" /></i></div>
                  
               
          
        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this product?</p>
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
            url: '{{ url("admin/product/search") }}',
            success: function(data) 
            {
                $('.loader').hide();
                $("#result").html(data);
                $(".mass[type='checkbox']").prop("checked",false);
            }
        });   
    }
    var typingTimer;                //timer identifier
    var doneTypingInterval = 1000;
    $('input[type=text],input[type=number],select').on('keyup change', function() {
        var search = $('#search').serialize();
        
        clearTimeout(typingTimer);
        if (search) {
            typingTimer = setTimeout(function(){
                //do stuff here e.g ajax call etc....
                 searchResult(search);
            }, doneTypingInterval);
           
        }
        
     });
    $(".mass[type='checkbox']").click(function(){
    if($(this).is(':checked')){
      $(".single[type='checkbox']").prop("checked",true);
    }
    else{
       $(".single[type='checkbox']").prop("checked",false);
    }
});
            $('#delete').click(function () {
                var mass = $('.mass').is(":checked");
                var single = $('.single').is(":checked");
                if (mass == true || single==true) {
                if (window.confirm('Are you sure to delete checked products permanently?')) {
                    var send = $('#send');
                        var toDelete = [];
                        $('.single').each(function () {
                            if ($(this).is(":checked")) {
                                toDelete.push($(this).data('id'));
                            }
                        });
                        send.val(JSON.stringify(toDelete));
                      $('#massDelete').submit();
                    }   
                }
            });
            
            localStorage.removeItem('selectedTab');  
        });
        
</script>

<script type="text/javascript"><!--
//$('#button-filter').on('click', function() {
//	var url = '';
//
//	var product_name = $('input[name=\'product_name\']').val();
//
//	if (product_name) {
//		url += '&product_name=' + encodeURIComponent(product_name);
//	}
////
////	var filter_model = $('input[name=\'filter_model\']').val();
////
////	if (filter_model) {
////		url += '&filter_model=' + encodeURIComponent(filter_model);
////	}
////
////	var filter_price = $('input[name=\'filter_price\']').val();
////
////	if (filter_price) {
////		url += '&filter_price=' + encodeURIComponent(filter_price);
////	}
////
////	var filter_quantity = $('input[name=\'filter_quantity\']').val();
////
////	if (filter_quantity) {
////		url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
////	}
//
//	var status = $('select[name=\'status\']').val();
//
//	if (status !== '') {
//		url += '&status=' + encodeURIComponent(status);
//	}
//        //var location = '{{url("admin/products")}}';
//        //console.log(location);
//	location = '{{url("admin/products?")}}' + url;
//});
////--></script>
@endsection

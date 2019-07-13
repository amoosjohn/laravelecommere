@extends('admin/admin_template')
@section('content')
<style>
.table {
    margin-bottom: 0px;
}
</style>
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
                <span class="caption-subject font-green bold uppercase"> Total Payments : {{ $model->total() }}  </span>
            
            </div>
            <div class="btn-group pull-right">
                <a href="{{ url('admin/payments/create') }}" class="btn sbold green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            </div>
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
                <form method="get" id="search" name="search">
                <table class="table table-striped table-bordered  table-checkable  no-footer">
                    <thead>
                        <tr>
                            <th style="width: 10%;"> Vendor </th>
                            <th style="width: 10%;"> Amount </th>
                            <th style="width: 10%;"> Payment Method </th>
                            <th style="width: 10%;">  No.</th>
                            <th style="width: 10%;"> Date of Payment  </th>
                            <th style="width: 10%;"> Received By </th>
                            <th style="width: 10%;"> Actions </th>
                        </tr>
                   
                    <tr role="row" class="filter">
                        <td>
                            {!! Form::select('user_id', $users,null , array('class' => 'form-control form-filter input-sm') ) !!}

                        </td>
                        <td></td>
                        <td>{!! Form::select('method', $methods,null , array('class' => 'form-control form-filter input-sm') ) !!}
</td>
                        <td></td>
                        <td>
                         <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control form-filter input-sm"  name="date" placeholder="To">
                            <span class="input-group-btn">
                                <button class="btn btn-sm default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                   </thead>
                </table>
               </form>
                 <div  id="result">
                        @include('admin.payments.search')
                 </div>
        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this payment?</p>
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
        $("#search-result").html("");
        $.ajax({
            type: 'GET',
            data: search,
            url: '{{ url("admin/payments/search") }}',
            success: function(data) 
            {
                $("#result").html(data);
            }
        });   
    }
    $('#search').on('keyup change', function() {
        var search = $('#search').serialize();
        searchResult(search);
     });
    $(document).ready(function(){
    localStorage.removeItem('selectedTab');  
    });
</script>
@endsection

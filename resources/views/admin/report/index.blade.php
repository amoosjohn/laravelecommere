@extends('admin/admin_template')
@section('content')
<style>
.table {
    margin-bottom: 0px;
}
</style>
<!-- Main row -->
<h1 class="page-title">Report</h1>
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
       
        <div class="portlet-body">
          
            <div class="table-scrollable">
               <form method="get" id="search" name="search">
                <table class="table table-striped table-bordered  table-checkable  no-footer">
                    <thead>
                        <tr role="row" class="heading">
                            <th style="width: 10%;"> Vendor Name </th>
                            <th style="width: 10%;"> Total order amount   </th>
                            <th style="width: 10%;"> Total commission </th>
                            <th style="width: 10%;"> Payment amount  </th>
                            <th style="width: 10%;"> Outstanding </th>
                            <th style="width: 10%;"> Action </th>
                        </tr>
                        <tr>
                        <td>
                          {!! Form::select('user_id', $users,null , array('class' => 'form-control form-filter input-sm') ) !!}

                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>
                        
                    
                    </thead>
                   </table>
                   </form>
                    <div  id="result">
                        @include('admin.report.search')
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
            url: '{{ url("admin/report/search") }}',
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

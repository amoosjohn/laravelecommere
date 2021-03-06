@extends('admin/admin_template')

@section('content')
<!-- Main row -->
<h1 class="page-title">Users</h1>
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
                <span class="caption-subject font-green bold uppercase"> Total Users : {{ $model->total() }}  </span>
            
            </div>
            <!--<div class="btn-group pull-right">
                <a href="{{ url('admin/products/create') }}" class="btn sbold green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            </div>-->
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
                <form class="form" role="form" id="search">
                <table class="table table-hover">
                    <thead>
                        <tr role="row" class="heading">
                            <th style="width: 8%;">#</th>
                            <th style="width: 15%;">First Name</th>
                            <th style="width: 15%;">Last Name</th>
                            <th style="width: 15%;">Email</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%;">Registration Date</th>
                            <th style="width: 10%;">Action</th>
                        </tr>
                       
                        <tr role="row" class="filter">
                       
                        
                        <td> </td>
                        <td>
                            {!! Form::text('firstName',null, array('class' => 'form-control form-filter input-sm', 'id' => 'firstName') ) !!} 
                        </td>
         
                        <td>
                          {!! Form::text('lastName',null, array('class' => 'form-control form-filter input-sm', 'id' => 'lastName') ) !!}

                        </td>
                        <td>
                           {!! Form::text('email',null, array('class' => 'form-control form-filter input-sm', 'id' => 'email') ) !!}
                        </td>

                        <td>
                            {!! Form::select('status', $status,null , array('class' => 'form-control form-filter input-sm') ) !!}

                        </td>
                        
                        <td></td>
                        <td> </td>
                       
                    </tr>
                    
                    </thead>
                   </table>
                   </form>
                    <div  id="result">
                        
                    </div>
                  
               
          
        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this user?</p>
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
    });
   
    
    $('#search').on('keyup change', function() {
        var search = $('#search').serialize();
        searchResult(search);
     });
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
        $.ajax({
            type: 'GET',
            url: "<?php echo url('admin/user/search'); ?>",
            dataType: 'html',
            data: search,
            success: function(response) 
            {
                $("#result").html(response);
            },
            error: function (xhr, status, response) {
            }
        });   
    }
  
    
    
</script>
@endsection

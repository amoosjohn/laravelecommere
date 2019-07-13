@extends('admin/admin_template')
@section('content')
<!-- Main row -->
<h1 class="page-title">Newsletter</h1>
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
                <span class="caption-subject font-green bold uppercase"> Total Newsletter : {{ $news->total() }}  </span>
            
            </div>
            <div class="dt-buttons pull-right">
                <a onclick="exportCsv();" class="dt-button buttons-csv buttons-html5 btn purple btn-outline" tabindex="0" aria-controls="sample_1" >
                        <span>Export</span></a>
            </div>
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th> Email </th>
                            <th> Added </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($news)>0)
                        @foreach($news as $row)
                        <tr>
                            <td>{{ $row->email }}</td>
                            <td>{{ date('d M Y',strtotime($row->created_at)) }}</td>
                            <td>
                                <a data-href="<?php echo url('admin/newsletter/delete/' . $row->id); ?>" data-target="#confirm-delete" class="btn btn-danger btn-sm delete"  data-toggle="modal" title="Delete">
                                <i class="fa fa-trash"></i></a>
                            </td>    
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3" class="text-center">Data not found!</td>
                           
                        </tr>
                        @endif
                    </tbody>
                </table>
        <?php echo $news->render(); ?>   
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this email?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok" id="btn-ok">Delete</a>
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
function exportCsv(){
        
        $.ajax({
            type: 'GET',
            url: '{{ url("admin/newsletter/export") }}',
            success: function(data) 
            {
                window.open('<?php echo url('uploads/newsletter')?>/'+data , '_blank');
               
            }
        });
}
</script>
@endsection

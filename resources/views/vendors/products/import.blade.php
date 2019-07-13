@extends('vendors/vendor_template')
<?php
$size = Config::get('params.best_image_size');
$required = "required";

if (Session::has('status')) {
    switch (session('status')) {
        case 'succ':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Data data has been inserted successfully.';
            break;
        case 'err':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg = '';
    }
}
?>
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        @include('vendors.commons.errors')
        <?php
        if (!empty($statusMsg)) {
            echo '<div class="alert ' . $statusMsgClass . ' alert-dismissable">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            ' . $statusMsg . '</div>';
        }
        ?>
        <div class="portlet light bordered"> 
        
            <div class="portlet-title">
                <h3 class="box-title">Import Products</h3>
            </div>
      
            <!-- /.box-header -->
    
            <div class="portlet-body"> 
                
                
                <div class="form-group pull-right">
                    <a onclick="exportCsv();" class="btn btn purple" tabindex="0" aria-controls="sample_1" >
                        <span><i class="fa fa-table"></i> Export Categories</span></a>
                    <a href="{{asset('uploads/format.csv')}}" class="btn btn-primary" download=""><i class="fa fa-download"></i> Download format</a>
                </div>
                <div class="form-group pull-right" style="margin-right:10px;">
                      <a href="{{url('filemanager')}}" target="_blank" class="btn btn-info"><i class="fa fa-cloud"></i> Upload Images</a>
                </div>
                {!! Form::open(array( 'class' => 'form','id' => 'myform','url' => 'vendor/product/upload', 'files' => true, 'id' => 'importFrm')) !!}
                
                <div class="form-group">
                    <input type="file" name="file" required=""/>
                    <input type="hidden" name="type" value="product" required=""/> 
                </div>
                <div class="form-group last">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Import</button>
                    <button type="button" onClick="window.location ='{{ url('vendor/products')}}';" class="btn btn-secondary-outline">
                        <i class="fa fa-angle-left"></i> Back</button>
                </div>
                {!! Form::close() !!}
          
            </div>
           
        </div>     
        <div class="portlet light bordered"> 
            <!-- /.box-body -->
             <div class="portlet-title">
                <h3 class="box-title">Download Images</h3>
             </div>
                <h4>Remaining Images: <label class="font-red sbold">{{$remainingImages}}</label></h4>
                <a data-href="{{ url('vendor/import/images') }}" data-target="#confirm-status" class="btn btn-success"  data-toggle="modal"  title="Import">Download Images</a>
                <div class="clearfix"></div>
                <p class="font-red sbold">Note: 100 Images will be download from url.</p>
                
            
        </div>
        <div class="portlet light bordered"> 
            <!-- /.box-body -->
             <div class="portlet-title">
                <h3>Update Product Price</h3>
             </div>
            <div class="portlet-body"> 
                <div class="form-group pull-right">
                    <a href="{{asset('uploads/prices.csv')}}" class="btn btn-primary" download=""><i class="fa fa-download"></i> Download price format</a>
                </div>
                
                {!! Form::open(array( 'class' => 'form','id' => 'myform','url' => 'vendor/product/prices', 'files' => true, 'id' => 'importFrm')) !!}
                
                <div class="form-group">
                    <input type="file" name="file" required=""/>
                    <input type="hidden" name="type" value="price" required=""/> 
                </div>
                <div class="form-group last">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
                    <button type="button" onClick="window.location ='{{ url('vendor/products')}}';" class="btn btn-secondary-outline">
                        <i class="fa fa-angle-left"></i> Back</button>
                </div>
                {!! Form::close() !!}
          
            </div>
               
            
        </div>
        </div>
        <!-- /.box -->
    </div>
</div>
<div class="modal fade" id="confirm-status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Download Images</h4>
            </div>

            <div class="modal-body">
                <p>Are you sure to download image?</p>
            </div>

            <div class="modal-footer">
                <a class="btn btn-info btn-status" id="btn-status" >Yes</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<script>
    function deleteCsv(file){
        var search = 'delete=1&file='+file; 
        $.ajax({
            type: 'GET',
            data: search,
            url: '{{ url("vendor/csv/delete") }}',
            success: function(data) 
            {
                return true;
            }
        });
    }
    function exportCsv(){
        $.ajax({
            type: 'GET',
            url: '{{ url("vendor/product/category/export") }}',
            success: function(data) 
            {
                window.open('<?php echo url('uploads/products/csv')?>/'+data , '_blank');
                setTimeout(function(){ deleteCsv(data); }, 5000);
                
               
            }
        });
    }
</script>    
@endsection

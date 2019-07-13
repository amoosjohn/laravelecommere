@extends('admin/admin_template')
<?php
$size = Config::get('params.best_image_size');
$required = "required";
?>
@section('content')
<h1 class="page-title"> Add New Product

</h1>
<div class="row">
    <div class="col-md-12">
        {!! Form::open(array( 'class' => 'form-horizontal form-row-seperated','url' => 'admin/products', 'files' => true)) !!}
        {!! Form::hidden('session_id',$session_id) !!}
        <div class="portlet">
            <div class="portlet-title">
                <div class="actions btn-set">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Save & Continue</button>
                    <button type="button" onClick="window.location ='{{ url('admin/products')}}';" class="btn btn-secondary-outline">
                        <i class="fa fa-angle-left"></i> Back</button>
                </div>
            </div>
            @include('admin/commons/errors')
            <div class="portlet-body">
                <div class="tabbable-bordered">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_general" data-toggle="tab"> General </a>
                        </li>
                        <li>
                            <a href="#tab_meta" data-toggle="tab"> Data </a>
                        </li>
                        <li>
                            <a href="#tab_images" data-toggle="tab"> Images </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_general">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Name:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::text('name', null , array('class' => 'form-control',$required) ) !!}
                                     </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Categories:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                            <select class="form-control" name="category_id" id="category_id" <?php echo $required ?>>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $row)
                                                @if($row->children->count() > 0)                            
                                                @foreach($row->children as $subcat)
                                                <option value="{{ $row->id }}">{{ $subcat->name }} > {{ $row->name }}</option>

                                                @endforeach                            
                                                @else
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Brand Name:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                       {!! Form::select('brand_id', $brands,null , array('class' => 'form-control',$required) ) !!}

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Colour Family:
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::select('colour_id', $colours,null , array('class' => 'form-control') ) !!}

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Status:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                       {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Short Description:</label>
                                    <div class="col-md-10">
                                       {!! Form::textarea('short_description', null, ['rows'=>'8','class' => 'form-control maxlength-handler','maxlength'=>'255']) !!} 

                                        <span class="help-block"> max 255 chars </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Description:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                       {!! Form::textarea('description', null, ['class' => 'form-control','id' => 'editor']) !!} 

                                    </div>
                                </div>
                                <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Meta Title:</label>
                                    <div class="col-md-10">
                                        {!! Form::text('meta_title', null , array('class' => 'form-control','maxlength' => '100') ) !!} 
                                        <span class="help-block"> max 100 chars </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Meta Keywords:</label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('meta_keyword', null, ['rows'=>'8','class' => 'form-control maxlength-handler','maxlength'=>'1000']) !!}
                                        <span class="help-block"> max 1000 chars </span>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Meta Description:</label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('meta_description', null, ['rows'=>'8','class' => 'form-control maxlength-handler','maxlength'=>'255']) !!}
                                        <span class="help-block"> max 255 chars </span>
                                    </div>
                                </div>
                            </div>
                               
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_meta">
                            <div class="form-group">
                                    <label class="col-md-2 control-label">Price:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::number('price', null , array('class' => 'form-control','step' => '0.01','min' => '1',$required) ) !!} 

                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Sale Price:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::number('sale_price', null , array('class' => 'form-control','step' => '0.01','min' => '1',$required) ) !!} 
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Discount:
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::number('discount', null , array('class' => 'form-control','step' => '0.01','min' => '1') ) !!} 
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">SKU:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                    {!! Form::text('sku', null , array('class' => 'form-control',$required) ) !!} 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Quantity:
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::number('quantity', 1 , array('class' => 'form-control','min' => '1') ) !!} 
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Out Of Stock Status:
                                    </label>
                                    <div class="col-md-10">
                                       {!! Form::select('stock_status', $stock_status,null , array('class' => 'form-control') ) !!}

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Available Date:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-group input-large date-picker input-daterange" data-date="10-11-2012" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control" name="date_available">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Requires Shipping</label>
                                    <div class="col-sm-10">
                                        <label class="radio-inline"> 
                                            <input type="radio" name="shipping" value="1" checked="checked">
                                            Yes
                                        </label>
                                        <label class="radio-inline"> <input type="radio" name="shipping" value="0">
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Weight (KG)</label>
                                    <div class="col-sm-10">
                                       {!! Form::number('weight',null, array('class' => 'form-control','min' => '1') ) !!} 

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-length">Dimensions (L x W x H)</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                {!! Form::number('length',null, array('class' => 'form-control','min' => '1','placeholder' => 'Length') ) !!} 

                                            </div>
                                            <div class="col-sm-4">
                                               {!! Form::number('width',null, array('class' => 'form-control','min' => '1','placeholder' => 'Width') ) !!} 

                                            </div>
                                            <div class="col-sm-4">
                                                 {!! Form::number('height',null, array('class' => 'form-control','min' => '1','placeholder' => 'Height') ) !!} 

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Return Policy:
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('return_policy', null, ['class' => 'form-control','id' => 'editor2']) !!} 

                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane" id="tab_images">
                            
                            <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
                                <a id="tab_images_uploader_pickfiles" onclick="window.open('<?php echo url('admin/product/addimage')."/".$session_id; ?>', '_blank', 'toolbar=no,scrollbars=yes,top=100,left=200,width=1000,height=600');" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Add an Image </a>
                                <a id="tab_images_uploader_uploadfiles" onclick="window.open('<?php echo url('admin/product/addmultiple')."/".$session_id; ?>', '_blank', 'toolbar=no,scrollbars=yes,top=100,left=200,width=1000,height=600');" class="btn btn-primary">
                                    <i class="fa fa-share"></i> Add Multiple Images </a>
                                <a class="btn btn-danger" data-href="{{ url('admin/product/deleteallimages').'/'.$session_id }}" data-target="#confirm-delete"   data-toggle="modal">
                                    <i class="fa fa-trash"></i> Delete All Images</a>
                            </div>
                          
                            <div class="row">
                                <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12"> </div>
                            </div>
                             <div id="gallery">
                            </div>
                            <table class="table table-bordered table-hover" style="visibility: hidden;display: none;">
                                                          
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <a style="visibility: hidden;display: none;" href="{{ url('admins/assets/pages/media/works/img1.jpg') }}" class="fancybox-button" data-rel="fancybox-button">
                                                                            <img  style="visibility: hidden;display: none;"class="img-responsive" src="{{ url('admins/assets/pages/media/works/img1.jpg') }}" alt=""> </a>
                                                                    </td>
                                                                    
                                                                </tr>
                                                               
                                                            </tbody>
                                                        </table>
                            
                        </div>
                    </div>  
                </div>    

            </div>
            {!! Form::close() !!}
            <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this all images?</p>
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

<script>
  $(document).ready(function () {
                var url = window.location;
                $('.sidebar-menu a[href="' + url + '"]').parents('li').addClass('active open');
                $('.sidebar-menu a[href="' + url + '"]').parent().addClass('open');

                $('.sidebar-menu a[href="' + url + '"]').closest('.nav-item').addClass('active');

                $('.sidebar-menu a[href="' + url + '"]').closest('.sub-menu').css("display", "block");



                $('.sidebar-menu a').filter(function () {
                    return this.href === url;
                }).parent().addClass('active');


            });
loadGallery();
function loadGallery()
{
    var product_id='<?php echo ($session_id)?$session_id:''; ?>';
         $.ajax({
            type:'get',
            url:'<?php echo url('admin/product/loadgallery'); ?>',
            data:{
              product_id:product_id,
              loadgllery:1
            },
          success:function(html){
                   
                 $('#gallery').html(html);
                        
                },
                error: function(errormessage) {
                      //you would not show the real error to the user - this is just to see if everything is working
                    
                    alert("Error ");
                }
      });
}

    
function display_order(image_id)
{
    
    var images = $('input[name="image_id[]"]').map(function(){ 
                    return this.value; 
     }).get();
     
    var order = $('select[name="display_order[]"]').map(function(){ 
                    return this.value; 
     }).get();
  
   var product_id='<?php echo ($session_id)?$session_id:''; ?>';
    
    
    $.ajax({
            type:'post',
            url:'<?php echo url('admin/product/insertorder'); ?>',
            data:{
              _token:'<?php echo csrf_token(); ?>',
              'image_id[]': images,
              'display_order[]':order,
               change_id:image_id,
               product_id:product_id
               
            },
          success:function(html){
                
                if(html==1)
                {
                    loadGallery();
                }
                 
                        
                },
                error: function(errormessage) {
                      //you would not show the real error to the user - this is just to see if everything is working
                    
                    alert("Error ");
                }
      });
    
      
}
</script>
@endsection

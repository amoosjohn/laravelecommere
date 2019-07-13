@extends('admin/admin_template')
<?php
$size = Config::get('params.best_image_size');
$required = "required";
?>
@section('content')
<h1 class="page-title"> Edit Product

</h1>
<div class="row">
    <div class="col-md-12">
        {!! Form::model($model, array('url' => 'admin/products/'.$model->id, 'method' => 'PUT', 'class' => 'form-horizontal form-row-seperated','files' => true)) !!}

        {!! Form::hidden('session_id',$session_id) !!}
        <div class="portlet">
            <div class="portlet-title">
                <div class="actions btn-set">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
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
                        <li>
                            <a href="#tab_sizes" data-toggle="tab"> Sizes </a>
                        </li>
                        <li>
                            <a href="#tab_var" data-toggle="tab"> Variations </a>
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
                                            <select class="form-control select2me" name="category_id" id="category_id" <?php echo $required ?>>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $row)
                                                <?php $selected = ($row->id==$model->category_id)?'selected':''; ?>
                                                <option value="{{ $row->id }}" <?php echo $selected;?>><?php echo ($row->parentName!='')?$row->parentName.' <strong>></strong> ':''; 
                                                echo ($row->categoryName!='')?$row->categoryName.' <strong>></strong> ':'';?> 
                                                {{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Brand Name:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                       {!! Form::select('brand_id', $brands,null , array('class' => 'form-control select2me',$required) ) !!}

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Colour Family:
                                         <span class="required"> * </span>
                                    </label>
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::select('colour_id', $colours,null , array('class' => 'form-control select2me',$required) ) !!}

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
                                        {!! Form::number('price', null , array('class' => 'form-control','id' => 'price','step' => '0.01','min' => '1',$required) ) !!} 

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Discount:
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::number('discount', null , array('class' => 'form-control','id' => 'discount','step' => '0.01','min' => '1') ) !!} 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Sale Price:
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::number('sale_price', null , array('class' => 'form-control','id' => 'salePrice','step' => '0.01','min' => '1','readonly' => 'true') ) !!} 
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
                                        {!! Form::number('quantity', null , array('class' => 'form-control','min' => '1') ) !!} 
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
                                    <div class="col-md-10">
                                        <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                            {!! Form::text('date_available',null, array('class' => 'form-control') ) !!} 

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
                        <div class="tab-pane" id="tab_sizes">
                        <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="10%"> Size</th>
                                    <th width="10%"> Quantity</th>
                                    <th width="10%"> Actions </th>
                                </tr>
                            </thead>
                            <tbody id="content">
                                @if(count($productSizes)>0)
                                @foreach($productSizes as $row)
                                <tr>
                                    <td>{!! Form::select('size_id[]', $sizes,$row->size_id , array('class' => 'form-control') ) !!}
                                    {!! Form::hidden('productsize_id[]', $row->id  ) !!}</td>

                                    <td>{!! Form::number('size_quantity[]', $row->quantity , array('class' => 'form-control','min' => '1') ) !!}</td>

                                    <td><a data-href="<?php echo url('admin/product/size/delete/'.$row->id); ?>" data-target="#confirm-delete"  class="btn btn-danger btn-sm"  data-toggle="modal" title="Delete">
                                        <i class="fa fa-minus"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>{!! Form::select('size_id[]', $sizes,null , array('class' => 'form-control') ) !!}
                                        {!! Form::hidden('productsize_id[]',0) !!}</td>

                                    <td>{!! Form::number('size_quantity[]', null , array('class' => 'form-control','min' => '1') ) !!}</td>

                                    <td></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right">       
                    <a id="addsize" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add new size</a> 
                    </div>                                
                        
                    </div> 
                    <div class="tab-pane" id="tab_var">
                        <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="50%"> Product Name</th>
                                    <th width="50%"> Actions </th>
                                </tr>
                            </thead>
                            <tbody id="var-content">
                                @if(count($productVars)>0)
                                @foreach($productVars as $row)
                                <tr>
                                    <td>{!! Form::select('variation_id[]', $products,$row->productvariation_id , array('class' => 'form-control select2me') ) !!}
                                    {!! Form::hidden('productvar_id[]', $row->id  ) !!}</td>
                                    <td><a data-href="<?php echo url('vendor/product/variation/delete/'.$row->id); ?>" data-target="#confirm-delete"  class="btn btn-danger btn-sm"  data-toggle="modal" title="Delete">
                                        <i class="fa fa-minus"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>{!! Form::select('variation_id[]', $products,null , array('class' => 'form-control select2me') ) !!}
                                    {!! Form::hidden('productvar_id[]', 0  ) !!}</td>

                                    <td></td>
                                </tr>
                                @endif    
                                
                            </tbody>
                        </table>
                    </div>
                       <a id="addvar" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> Add new variation</a> 
                        
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
$('#addsize').click(function(){
  
    $('#content').append('<tr><td>{!! Form::select('size_id[]', $sizes,null , array('class' => 'form-control') ) !!}{!! Form::hidden('productsize_id[]', 0  ) !!}</td><td>{!! Form::number('size_quantity[]', null , array('class' => 'form-control','min' => '1') ) !!}</td><td><button type="button" class="btn btn-danger btn-sm removebutton"><i class="fa fa-minus"></i></button></td></tr>');
   
});
$('#addvar').click(function(){
  
    $('#var-content').append('<tr><td>{!! Form::select('variation_id[]', $products,null , array('class' => 'form-control select2me') ) !!}{!! Form::hidden('productvar_id[]', 0  ) !!}</td><td><button type="button" class="btn btn-danger btn-sm removebutton"><i class="fa fa-minus"></i></button></td></tr>');
   
}); 
  
$(document).on('click', 'button.removebutton', function () {
     
     $(this).closest('tr').remove();
     return false;
 });
 $('#price,#discount').on('keyup', function() {
   
   var price = $("#price").val();
   var discount = $("#discount").val();
   if(price!='' && discount!='')
   {
       var salePrice = price - price * discount / 100;
       $("#salePrice").val(Math.round(salePrice));
   }   
   
});
</script>
@endsection

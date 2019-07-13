@extends('admin/admin_template')
<?php
$size = Config::get('params.best_image_size');
$required = "required";
?>
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<style>
.box-body .form-control{border-radius: 4px;}
.panel{
  border-radius: 0px;
  margin-bottom: 0px;
 border-bottom: 1px dashed #ddd;
}
.view-btn{

  background: #ddd;
    height: 40px;
  line-height: 40px;
  width: 100px;
  text-align: center;
  margin: 0 auto;
  display: block;
      z-index: 8;
    position: relative;
    border-radius: 4px;
      transition-timing-function: ease-in;

  /* Quick on the way out */
  transition: 0.2s;
}
.view-btn a{
  color:#000;
  display: block;
  transition-timing-function: ease-in;

  /* Quick on the way out */
  transition: 0.2s;
}

.view-btn:hover{background: #26ABE2;}
.view-btn a:hover{color: #fff;}
.label-style{
  /*padding-right: 0px;*/
  text-align: center;
display: table;
margin: 0 auto;
}
.gallery{ overflow: hidden;position: relative;}
.gallery ul{ margin:0; padding:0; list-style-type:none;}
.gallery ul li{ margin: 10px 0px; }
.gallery img{ width:200px;height: 150px;}
.m10 {
    margin: 10px 0;
}
</style>
<script>
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
</script>
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
                        <!--<li>
                            <a href="#tab_var" data-toggle="tab"> Variations </a>
                        </li>-->

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_general">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Categories:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <div class="row" data-selectsplitter-wrapper-selector="">
                                            <div class="col-xs-12 col-sm-4">
                                                <select class="form-control" id="parent" data-selectsplitter-firstselect-selector="" size="8" <?php echo $required ?> >
                                                 @foreach($categories as $row)
                             
                                                <option value="{{ $row->id }}" <?php echo ($parentId==$row->id)?'selected':''; ?>>
                                                    {{ $row->name }} <strong>></strong></option>
                                               
                                                @endforeach
                                                </select>
                                            </div> <!-- Add the extra clearfix for only the required viewport -->
                                            <div class="clearfix visible-xs-block"></div>
                                            <div class="col-xs-12 col-sm-4">
                                                <select class="form-control" id="category" data-selectsplitter-secondselect-selector="" size="8" <?php echo $required ?> >
                                                </select>
                                            </div>
                                            <div class="clearfix visible-xs-block"></div>
                                            <div class="col-xs-12 col-sm-4">
                                                <select class="form-control" id="subcategory" name="category_id" <?php echo $required ?> data-selectsplitter-secondselect-selector="" size="8">
                                                </select>
                                            </div>
                                        </div>
                                        <p class="help-block"> click on the main option to list its child items </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Name:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::text('name', null , array('class' => 'form-control',$required) ) !!}
                                     </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Brand Name:
                                    </label>
                                    <div class="col-md-10">
                                       {!! Form::select('brand_id', $brands,null , array('class' => 'form-control select2me') ) !!}

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
                                    <label class="col-md-2 control-label">Is Popular:
                                    </label>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                          <div class="icheck-inline">
                                        {!! Form::checkbox('popular', 1, null,array('class'=>'icheck','data-checkbox'=>'icheckbox_square-blue')) !!}
                                         </div>
                                       </div>
                                     </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Product Order:
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::number('sortOrder', null , array('class' => 'form-control','min' => '0') ) !!} 
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
                                        {!! Form::number('price', null , array('class' => 'form-control','id' => 'price','min' => '0',$required) ) !!} 

                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-md-2 control-label">Discount %:
                                </label>
                                <div class="col-md-10">
                                    {!! Form::number('discount', null , array('class' => 'form-control','id' => 'discount','min' => '0','max' => '100') ) !!} 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Sale Price:
                                </label>
                                <div class="col-md-10">
                                    {!! Form::number('sale_price', null , array('class' => 'form-control','id' => 'salePrice','min' => '0','readonly' => 'true') ) !!} 
                                </div>
                            </div>
                            <div class="form-group" id="control-comm">
                                <label class="col-md-2 control-label">Commission:
                                </label>
                                <div class="col-md-10">
                                    {!! Form::text('commission', null , array('class' => 'form-control','id' => 'commission','min' => '0','readonly' => 'true') ) !!} 
                                    <span class="label label-danger sbold" id="errorMessage"></span>
                                </div>
                            </div>
                            <div class="form-group" id="control-comm">
                                <label class="col-md-2 control-label">Cost Price:
                                </label>
                                <div class="col-md-10">
                                    {!! Form::text('costPrice', null , array('class' => 'form-control','id' => 'costPrice','min' => '0','readonly' => 'true') ) !!} 
                                    <span class="label label-danger sbold" id="errorMessage"></span>
                                </div>
                            </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">SKU:
<!--                                        <span class="required"> * </span>-->
                                    </label>
                                    <div class="col-md-10">
                                    {!! Form::text('sku', null , array('class' => 'form-control') ) !!} 
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
                                        <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                            {!! Form::text('date_available',null, array('class' => 'form-control','readonly' => 'true') ) !!} 
                                            <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
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
                                    <label class="col-md-2 control-label">Weight (KG)
                                       <span class="required"> * </span>
                                    </label>
                                    <div class="col-sm-10">
                                       {!! Form::number('weight',null, array('class' => 'form-control','step' => '0.01',$required) ) !!} 

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-length">Dimensions (L x W x H)</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                {!! Form::number('length',null, array('class' => 'form-control','step' => '0.01','placeholder' => 'Length') ) !!} 

                                            </div>
                                            <div class="col-sm-4">
                                               {!! Form::number('width',null, array('class' => 'form-control','step' => '0.01','placeholder' => 'Width') ) !!} 

                                            </div>
                                            <div class="col-sm-4">
                                                 {!! Form::number('height',null, array('class' => 'form-control','step' => '0.01','placeholder' => 'Height') ) !!} 

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="input-length">Delivery:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::text('delivery',null, array('class' => 'form-control','placeholder' => 'Delivery',$required) ) !!}
                                </div>
                            </div>
                            
                               
                            <div class="form-group">
                                <label class="col-md-2 control-label">Warranty:</label>
                                <div class="col-md-10">
                                    {!! Form::text('warranty', null, ['class' => 'form-control maxlength-handler','maxlength'=>'255']) !!}
                                    <span class="help-block"> max 255 chars </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Material:</label>
                                <div class="col-md-10">
                                    {!! Form::text('material', null , array('class' => 'form-control','maxlength' => '100') ) !!} 
                                    <span class="help-block"> max 100 chars </span>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                    <label class="col-md-2 control-label">Return Policy:
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('return_policy', null, ['class' => 'form-control','id' => 'editor2']) !!} 

                                    </div>
                                </div>-->
                        </div>
                        <div class="tab-pane" id="tab_images">
                            
                            <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
<!--                                <a id="tab_images_uploader_pickfiles" onclick="window.open('<?php echo url('admin/product/addimage')."/".$session_id; ?>', '_blank', 'toolbar=no,scrollbars=yes,top=100,left=200,width=1000,height=600');" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Add an Image </a>
                                <a id="tab_images_uploader_uploadfiles" onclick="window.open('<?php echo url('admin/product/addmultiple')."/".$session_id; ?>', '_blank', 'toolbar=no,scrollbars=yes,top=100,left=200,width=1000,height=600');" class="btn btn-primary">
                                    <i class="fa fa-share"></i> Add Images </a>-->
                                <a class="btn btn-danger" data-href="{{ url('admin/product/deleteallimages').'/'.$session_id }}" data-target="#confirm-delete"   data-toggle="modal">
                                    <i class="fa fa-trash"></i> Delete All Images</a>
                            </div>
                          
                            <div class="row">
                           
                            <div id="gallery" class="gallery">
                            </div>
                            <table class="table table-bordered table-hover" style="visibility: hidden;display: none;">
                                                          
                            <tbody>
                                <tr>
                                    <td>
                                        <a style="visibility: hidden;display: none;" href="{{ asset('front/images/no-image.jpg') }}" class="fancybox-button" data-rel="fancybox-button">
                                            <img  style="visibility: hidden;display: none;"class="img-responsive" src="{{ asset('front/images/no-image.jpg') }}" alt=""> </a>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                             </div>
                        </div>
                        <div class="tab-pane" id="tab_sizes">
                        <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="10%"> Size</th>
                                    <th width="10%"> Quantity</th>
                                    <th width="10%"> Child Sku </th>
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
                                    <td>{!! Form::text('childSku[]', $row->sku , array('class' => 'form-control') ) !!}</td>

                                    <td><a data-href="<?php echo url('admin/product/size/delete/'.$row->id); ?>" data-target="#confirm-delete"  class="btn btn-danger btn-sm"  data-toggle="modal" title="Delete">
                                        <i class="fa fa-minus"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>{!! Form::select('size_id[]', $sizes,null , array('class' => 'form-control') ) !!}
                                        {!! Form::hidden('productsize_id[]',0) !!}</td>

                                    <td>{!! Form::number('size_quantity[]', null , array('class' => 'form-control','min' => '1') ) !!}</td>
                                    <td>{!! Form::text('childSku[]', null , array('class' => 'form-control') ) !!}</td>

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
                    <!--<div class="tab-pane" id="tab_var">
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
                        
                    </div>-->
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
<style>

.upload-preview__img {
	width:100%;
    height: 300px;
    border: 1px solid #d2d6de;
    overflow: hidden;
        padding: 0 10px;
}
.upload-preview__img img {
	position: relative;
    width:  100%;
}
.upload-preview input {
   
   
}
.upload-preview  {
	padding:0;
}
div#uploadPreview {
    position:  relative;
}
.upload_hed {
	margin-bottom:10px;
}
.upload-img_box {
    margin-bottom:  40px;
}
.upload-preview p {
    width:  100%;
    position:  absolute;
    top:  0;
    left:  0;
    right:  0;
    bottom:  0;
    font-size:  20px;
    padding-top:  115px;
    text-align:  center;
}
.form-horizontal .form-group.upload {
    margin: 10px 0;
}


</style>

<script>
		jQuery('[type=file]').change(function(){
			var curElement = jQuery(this).parent().parent().find('.upload-preview__img img');
			console.log(curElement);
			var reader = new FileReader();
			reader.onload = function (e) {
			// get loaded data and render thumbnail.
			curElement.attr('src', e.target.result);
			};
			// read the image file as a data URL.
			reader.readAsDataURL(this.files[0]);
		});
		
</script>
<script>
$(document).ready(function(){ 
$('#addsize').click(function(){
  
    $('#content').append('<tr><td>{!! Form::select('size_id[]', $sizes,null , array('class' => 'form-control') ) !!}{!! Form::hidden('productsize_id[]', 0  ) !!}</td><td>{!! Form::number('size_quantity[]', null , array('class' => 'form-control','min' => '1') ) !!}</td><td>{!! Form::text('childSku[]', null , array('class' => 'form-control') ) !!}</td><td><button type="button" class="btn btn-danger btn-sm removebutton"><i class="fa fa-minus"></i></button></td></tr>');
   
});

  
$(document).on('click', 'button.removebutton', function () {
     
     $(this).closest('tr').remove();
     return false;
 });
$('#price,#discount').on('keyup change', function() {
   
   var price = $("#price").val();
   var discount = $("#discount").val();
   if(price!='' && discount!='')
   {
       var salePrice = price - price * discount / 100;
       $("#salePrice").val(Math.round(salePrice));
   }
   else if(discount==''){
       $("#salePrice").val('');
   } 
});
 $('#price,#discount,#category_id').on('keyup change', function() {
   
   var category = $("#category_id").val();
   var price = $("#price").val();
   if(category!='' && price!='') {
    
    var salePrice = $("#salePrice").val();
    
    if(salePrice!=0 && salePrice!='')
    {
      price = salePrice;
    }
    
    getCommission(category,price);
   }
   else {
       $("#errorMessage").text("Category not selected!").fadeIn('fast');
       $("#control-comm").addClass("has-error");
       
       
       setTimeout(function() {
            $('#errorMessage').fadeOut('fast');
            $('#control-comm').removeClass('has-error');
       }, 10000);
   }
   
});
$('#price,#discount,#subcategory').on('keyup change', function() {
   
   var category = $("#subcategory").val();
   var price = $("#price").val();
   if(category!='' && price!='') {
    
    var salePrice = $("#salePrice").val();
    
    if(salePrice!=0 && salePrice!='')
    {
      price = salePrice;
    }
    
    getCommission(category,price);
   }
   else {
       $("#errorMessage").text("Category not selected!").fadeIn('fast');
       $("#control-comm").addClass("has-error");
       
       
       setTimeout(function() {
            $('#errorMessage').fadeOut('fast');
            $('#control-comm').removeClass('has-error');
       }, 10000);
   }
   
});
getCommission(<?php echo $model->category_id;?>,<?php echo ($model->sale_price!=0)?$model->sale_price:$model->price;?>);
function getCommission(category,price) {
    
    $.ajax({
            type:'get',
            url:'<?php echo url('admin/product/commission'); ?>',
             data:{
               id:category,
               price:price
               
            },
          success:function(data){
            $('#errorMessage').fadeOut('fast');
            $('#control-comm').removeClass('has-error');
            
            $('#commission').val(data);
            var costPrice=0;
            var salePrice = $("#salePrice").val();
            if(salePrice!=0 && salePrice!='')
            {
               price = salePrice;
            }
            costPrice = price-data;
            $('#costPrice').val(costPrice);
         },
        error: function(errormessage) {
              //you would not show the real error to the user - this is just to see if everything is working

            //alert("Error ");
        }
      });
}
getCategory('<?php echo $parentId?>',1,'<?php echo $categoryId?>');

setTimeout(function(){ getCategory('<?php echo $categoryId?>',2,'<?php echo $model->category_id?>'); }, 1000)

function getCategory(category,level,id='') {
    
    $.ajax({
            type:'get',
            url:'<?php echo url('admin/category'); ?>',
             data:{
               id:category,
               category_id:id,
            },
          success:function(data){
            $('#errorMessage').fadeOut('fast');
            $('#control-comm').removeClass('has-error');
            if(level==1) {
                $('#category').html(data);
                $('#subcategory').html("");
            }
            if(level==2) {
                $('#subcategory').html(data);
            }
            
         },
        error: function(errormessage) {
              //you would not show the real error to the user - this is just to see if everything is working

            //alert("Error ");
        }
      });
}
$('#parent').on('click', function() {
   
   var category = $("#parent").val();
   if(category!='' ) {
        getCategory(category,1);
   }
   
   
});
$('#category').on('click', function() {
   
   var category = $("#category").val();
   if(category!='' ) {
        getCategory(category,2);
   }
   
   
});
});
</script>
@endsection

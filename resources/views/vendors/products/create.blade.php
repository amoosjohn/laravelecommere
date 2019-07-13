@extends('vendors/vendor_template')
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
            url:'<?php echo url('vendor/product/loadgallery'); ?>',
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
<h1 class="page-title"> Add New Product

</h1>
<div class="row">
    <div class="col-md-12">
        {!! Form::open(array( 'class' => 'form-horizontal form-row-seperated','name' => 'myform','url' => 'vendor/products', 'files' => true)) !!}
        {!! Form::hidden('session_id',$session_id) !!}
        <div class="portlet">
            <div class="portlet-title">
                <div class="actions btn-set">
                    <button type="button" id="next" class="btn green"><i class="fa fa-check"></i> Save & Continue</button>
                    <button type="button" onClick="window.location ='{{ url('vendor/products')}}';" class="btn btn-secondary-outline">
                        <i class="fa fa-angle-left"></i> Back</button>
                </div>
            </div>
            @include('vendors/commons/errors')
            <div class="portlet-body">
                <div id="errorMsg" class="font-red-thunderbird sbold"></div>
                <div class="tabbable-bordered">
                    <ul class="nav nav-tabs">
                        <li class="active" id="gen">
                            <a href="#tab_general" data-toggle="tab"> General </a>
                        </li>
                        <li id="meta" style="pointer-events: none;">
                            <a href="#tab_meta" data-toggle="tab"> Data </a>
                        </li>
                        <li id="image" style="pointer-events: none;">
                            <a href="#tab_images" data-toggle="tab"> Images </a>
                        </li>
                        <li id="size" style="pointer-events: none;">
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
                             
                                                <option value="{{ $row->id }}">{{ $row->name }} <strong>></strong></option>
                                               
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
<!--                                        <span class="required"> * </span>-->
                                    </label>
                                    <div class="col-md-10">
                                       {!! Form::select('brand_id', $brands,null , array('class' => 'form-control brand_id select2me') ) !!}

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Colour Family:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::select('colour_id', $colours,null , array('class' => 'form-control colour_id select2me',$required) ) !!}

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Status:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                       {!! Form::select('status', $status,null , array('class' => 'form-control status',$required) ) !!}

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
                                       {!! Form::textarea('description', null, ['class' => 'form-control','id' => 'editor',$required]) !!} 

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
                                        {!! Form::textarea('meta_keyword', null, ['rows'=>'8','class' => 'form-control maxlength-handler','maxlength'=>'255']) !!}
                                        <span class="help-block"> max 255 chars </span>
                                        
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
                                <label class="col-md-2 control-label">Discount %:
                                </label>
                                <div class="col-md-10">
                                    {!! Form::number('discount', null , array('class' => 'form-control','id' => 'discount','min' => '1','max' => '100') ) !!} 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Sale Price:
                                </label>
                                <div class="col-md-10">
                                    {!! Form::number('sale_price', null , array('class' => 'form-control','id' => 'salePrice','step' => '0.01','min' => '1','readonly' => 'true') ) !!} 
                                </div>
                            </div>
                            <div class="form-group" id="control-comm">
                                <label class="col-md-2 control-label">Commission:
                                </label>
                                <div class="col-md-10">
                                    {!! Form::text('commission', null , array('class' => 'form-control','id' => 'commission','min' => '1','readonly' => 'true') ) !!} 
                                    <span class="label label-danger sbold" id="errorMessage"></span>
                                </div>
                            </div>
                            <div class="form-group" id="control-comm">
                                <label class="col-md-2 control-label">Cost Price:
                                </label>
                                <div class="col-md-10">
                                    {!! Form::text('costPrice', null , array('class' => 'form-control','id' => 'costPrice','min' => '1','readonly' => 'true') ) !!} 
                                    <span class="label label-danger sbold" id="errorMessage"></span>
                                </div>
                            </div>
                                
                                <div class="form-group">
                                    <label class="col-md-2 control-label">SKU:
<!--                                        <span class="required"> * </span>-->
                                    </label>
                                    <div class="col-md-10">
                                    {!! Form::text('sku', null , array('class' => 'form-control sku') ) !!} 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Quantity:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        {!! Form::number('quantity', 1 , array('class' => 'form-control quantity','min' => '1') ) !!} 
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
                                            {!! Form::text('date_available',null, array('class' => 'form-control date_available','readonly' => 'true') ) !!} 
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
                                       {!! Form::number('weight',null, array('class' => 'form-control weight','step' => '0.01',$required) ) !!} 

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
                                <!-- <a id="tab_images_uploader_pickfiles" onclick="window.open('<!--?php echo url('vendor/product/addimage/'.$session_id); ?>', '_blank', 'toolbar=no,scrollbars=yes,top=100,left=200,width=1000,height=600');" class="btn btn-success">
                                <i class="fa fa-plus"></i> Add an Image </a>
                                <a id="tab_images_uploader_uploadfiles" onclick="window.open('<!--?php echo url('vendor/product/addmultiple/'.$session_id); ?>', '_blank', 'toolbar=no,scrollbars=yes,top=100,left=200,width=1000,height=600');" class="btn btn-primary">
                                   <!-- <i class="fa fa-share"></i> Add Images </a>-->
                                <!-- <a class="btn btn-danger" data-href="<!--?php echo url('vendor/product/deleteallimages/'.$session_id); ?>" data-target="#confirm-delete"   data-toggle="modal">
                                    <i class="fa fa-trash"></i> Delete All Images</a> -->
                           </div>
                            <div class="row">
                             
                               <div class="clearfix"></div>
                             <div id="gallery" class="gallery" >
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
                                <tr>
                                    <td>{!! Form::select('size_id[]', $sizes,null , array('class' => 'form-control') ) !!}</td>

                                    <td>{!! Form::number('size_quantity[]', null , array('class' => 'form-control','min' => '1') ) !!}</td>

                                    <td>{!! Form::text('childSku[]', null , array('class' => 'form-control') ) !!}</td>

                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                            <a id="addsize" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> Add new size</a> 
                                                     
                        
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
                                <tr>
                                    <td>{!! Form::select('variation_id[]', $products,null , array('class' => 'form-control select2me') ) !!}</td>

                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                       <a id="addvar" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> Add new variation</a> 
                        
                    </div>-->     
                        
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
$('#addsize').click(function(){
  
    $('#content').append('<tr><td>{!! Form::select('size_id[]', $sizes,null , array('class' => 'form-control') ) !!}{!! Form::hidden('productsize_id[]', 0  ) !!}</td><td>{!! Form::number('size_quantity[]', null , array('class' => 'form-control','min' => '1') ) !!}</td><td>{!! Form::text('childSku[]', null , array('class' => 'form-control') ) !!}</td><td><button type="button" class="btn btn-danger btn-sm removebutton"><i class="fa fa-minus"></i></button></td></tr>');
   
});
$(document).ready(function () {
var count = 1;
$('body').on("click", "#addvar", function(event) {  
     event.preventDefault();
  
});
});
//
  
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
$('#price,#discount,#subcategory').on('keyup change', function() {
   
   var category = $("#subcategory").val();
   var price = $("#price").val();
   if(category!='' && price!='') {
    
    var salePrice = $("#salePrice").val();
    
    if(salePrice!='')
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
function getCommission(category,price) {
    
    $.ajax({
            type:'get',
            url:'<?php echo url('vendor/product/commission'); ?>',
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
            if(salePrice!='')
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
function getCategory(category,level) {
    
    $.ajax({
            type:'get',
            url:'<?php echo url('vendor/categories'); ?>',
             data:{
               id:category,               
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
function removeError()
{
    setTimeout(function(){ $('#errorMsg').fadeOut("fast"); }, 3000);
}
$(document).on('click', '#next', function () {
        var Errorimg = 'Please fill out all required (*) fields.';
        var error=0;
        if ($("input[name='category_id']").val() == '') {
           error=1;
        }
        else if ($("input[name='name']").val() == '') {
            error=1;
        }
        else if ($(".colour_id").val() == '') {
           error=1;
        }
        else if ($(".status").val() == '') {
           error=1;
        }
//        else if ($(".description").val() == '') {
//           error=1;
//        }
        if(error==1)
        {
            $('#errorMsg').html(Errorimg).show();
            removeError();
            return false;
        }
        else
        {
            $('#errorMsg').hide();
            $('li#meta').fadeIn("fast").removeAttr("style");
            $('ul.nav.nav-tabs li.active').removeClass( 'active' );
            $('li#meta').addClass( 'active' );
            $('.tab-pane.active').removeClass('active');
            $('#tab_meta').addClass('active');
            removeError();
            $(this).attr('id','next2');
        }
        
        
});
$(document).on('click', '#next2', function () {
    
    var Errorimg = 'Please fill out all required (*) fields.';
    var error=0;
    if ($("#price").val() == '') {
       error=1;
    }
//    else if ($(".sku").val() == '') {
//        error=1;
//    }
    else if ($(".quantity").val() <= 0) {
        error=1;
    }
    else if ($(".weight").val() == '') {
       error=1;
    }
    else if ($(".date_available").val() == '') {
       error=1;
    }
    else if ($(".delivery_from").val() == '' && $(".delivery_to").val() == '') {
       error=1;
    }
    
    if(error==1)
    {
        $('#errorMsg').html(Errorimg).show();
        removeError();
        return false;
    }
    else
    {
        $('#errorMsg').hide();
        $('li#image').fadeIn("fast").removeAttr("style");
        $('ul.nav.nav-tabs li.active').removeClass( 'active' );
        $('li#image').addClass( 'active' );
        $('.tab-pane.active').removeClass('active');
        $('#tab_images').addClass('active');
        $('li#size').fadeIn("fast").removeAttr("style");
        removeError();
        $(this).attr('id','next3');
    }
    
});
$(document).on('click', '#next3', function () {
    var gallery = loadGallery();
    if(gallery=='')
    {
        var Errorimg = 'Please add an image';
        $('#errorMsg').html(Errorimg).show();
        removeError();
    }
    else
    {
        document.myform.submit();
    }
    
});
</script>
@endsection

<ul class="reorder_ul reorder-photos-list">
@if(count($gallery_images)>0)
@foreach($gallery_images as $image) 
{!! Form::hidden('image_id[]', $image->id ) !!}
<li id="image_li_{{ $image->id }}" class="ui-sortable-handle form-group upload col-sm-3 p0">
    <div class="upload-preview col-sm-12" id="uploadPreview">
     <div class="upload-preview__img mb30">
    <div class="view-btn">
        <a href="{{ asset('/'.$image->url) }}" class="fancybox-button" data-rel="fancybox-button">
            {{ ($image->sort_order==1)?'Main Photo':'View' }}
        </a>
    </div>  
    
        <img class="img-responsive" src="{{ asset('/'.$image->url) }}"  alt=""> 
   
    <div class="col-sm-12">  
        <div class="form-group">
            {!! Form::label('Caption:') !!}  
            {!! Form::text('image_caption[]', $image->image_caption , array('class' => 'form-control') ) !!}
        </div>
        <div class="form-group">
            <a onClick="confirmDelete('{{ $image->id }}');"  class="btn btn-danger btn-sm label-style">Remove</a>
        </div>

    </div>
         </div>
  </div>
</li>       
@endforeach
@endif
@for($i=count($gallery_images);$i<8;$i++)
<li id="" class="disabled">
   
    <div class="form-group upload col-sm-3 p0" onclick="window.open('<?php echo url('admin/product/addimage/'.$product_id); ?>', '_blank', 'toolbar=no,scrollbars=yes,top=100,left=400,width=800,height=600');">
        <div class="upload-preview col-sm-12" id="uploadPreview">
            <p>Click here to upload</p>
            <div class="upload-preview__img mb30">
                
            </div>
        </div>		
    </div>	
   
</li>
@endfor
</ul>
<script>
    function confirmDelete(id)
    {
        var r = confirm("Are you sure to delete this Item?");
        if (r == true) {
            
            $.ajax({
            type:'get',
            url:'<?php echo url('admin/product/deleteimage'); ?>/'+id,
            success:function(html){

                 loadGallery();

                },
                error: function(errormessage) {
                      //you would not show the real error to the user - this is just to see if everything is working

                    alert("Error ");
                }
        });
            
        } else {
            
            return false;
        }
    }
$(document).ready(function(){
$('.reorder_link').attr("id","save_reorder");
$('#reorder-helper').slideDown('slow');
$('.image_link').attr("href","javascript:void(0);");
$('.image_link').css("cursor","move");


$("ul.reorder-photos-list").sortable({ 
        tolerance: 'pointer',
        items: "li:not(.disabled)",
        start: function(event, ui) {
            var oldIndex = ui.item.index() + 1;
            ui.item.data('oldIndex', oldIndex);
            ui.placeholder.height(ui.item.height());
         },
        update: function (event, ui) {
        $("#gallery .overlay").show();
        $("ul.reorder-photos-list").sortable('destroy');    
        var h = [];
        $("ul.reorder-photos-list li").each(function() {  h.push($(this).attr('id').substr(9));  });

        $.ajax({
            type:'post',
            url:'<?php echo url('admin/product/insertorder'); ?>',
            data:{
            _token:'<?php echo csrf_token(); ?>',
            ids: " " + h + "",
            product_id:'<?php echo ($product_id)?$product_id:''; ?>',
            },
            success: function(){
                    loadGallery();
            }
        });	
        return false;

     }
   });
   $("ul.reorder-photos-list").disableSelection();
});    
</script>

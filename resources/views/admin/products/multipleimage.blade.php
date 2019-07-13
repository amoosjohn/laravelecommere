@extends('admin/commons/popup')

@section('content')
@if(Session::has('pageclose'))
 <script>
function refreshParent() {

  window.opener.loadGallery();
  window.close();
}
refreshParent();
     </script>
@endif
<script> 
    function refreshParent() {

  window.opener.loadGallery();
  window.close();
}

        $(document).ready(function() { 

         var progressbar = $('.progress-bar');

             $("#upload").click(function(){
                
            	$(".form").ajaxForm(
		{
		  target: '.preview',
		  beforeSend: function() {
			$(".progress").css("display","block");
			progressbar.width('0%');
			progressbar.text('0%');
                    },
		    uploadProgress: function (event, position, total, percentComplete) {
		        progressbar.width(percentComplete + '%');
		        progressbar.text(percentComplete + '%');
                        percen=percentComplete;
		     },
                     complete: function(response) { // on complete
                       
                        var error=response.responseText;
                       if (error==0) {
                           
                            setTimeout(function(){ refreshParent(); }, 2000)
                                
                            } 
                           else {
                                var errorsHtml = '<div class="alert alert-danger alert-dismissable"><a href="#" class="pull-right" data-dismiss="alert" aria-label="close">&times;</a><ul>';
                               
                                errorsHtml += error; //showing only the first error.
                               
                                errorsHtml += '</ul></div>';
                                $('#errors').html(errorsHtml).show();
                            }

                    }
		});
		    
            });

        }); 
    </script>
 <script>

var loadImageFile = (function () 
{
    if (window.FileReader) {
        var   oPreviewImg = null, oFReader = new window.FileReader(),
            rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

       
        return function () {
            var aFiles = document.getElementById("image").files;
            if (aFiles.length === 0) { return; }
            if (!rFilter.test(aFiles[0].type)) { 
                alert("You must select a valid image file !");
                var $el = $('#image');
                $el.wrap('<form>').closest('form').get(0).reset();      

                return; 
            }
            oFReader.readAsDataURL(aFiles[0]);
        }

    }

})();

</script>
<?php
      $required="required";
?>

<div class="row">
    <div class="col-md-12 images__add">
        <div id="errors"></div>
        @include('admin/commons/errors')
        {!! Form::open(array( 'class' => 'form','url' => 'admin/product/uploadmultiple', 'files' => true)) !!}
        {!! Form::hidden('product_id',$product_id) !!}
       <div class="col-sm-12 file__box">
            <div class="form-group">
                <strong>Drop files here to upload:</strong>
                {!! Form::file('images[]', array('class' => 'form-control','id' => 'image','onchange' => 'loadImageFile();','multiple'=>true,'accept'=>'image/*',$required)) !!}
                 <h3>Note: <br/>Maximum file size is 2MB<br/>Image width and height should be (900x500)</h3> 
            </div>
            <div class="progress" style="display:none">
            <div class="progress-bar" role="progressbar" aria-valuenow="0"
				  aria-valuemin="0" aria-valuemax="100" style="width:0%">
				    0%
            </div>
	  </div>
        </div>
        <div class="col-md-12 file__btn">
            {!! Form::submit('Save', array('class'=>'btn btn-primary btn-success btn1','id'=>'upload')) !!}
            <button type="button" class="btn btn-danger btn2" onclick="window.close();">Close</button>
        </div>
         {!! Form::close() !!}
    </div>    
</div>



@endsection

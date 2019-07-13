<style>
    .file-drop-area.fnc-uplaod {
    float: left;
}
img.img-responsive.img-thumbnail {
    width: 300px;
    height: 200px;
}
textarea.form-control {
    height: 200px;
    resize: none;
}
</style>
<?php
$size = Config::get('params.best_image_size') ;
$required = "required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('Title') !!}
    {!! Form::text('title', null , array('class' => 'form-control','maxlength' => '255') ) !!}

</div>
<div class="form-group">
    {!! Form::label('Type*') !!}
    {!! Form::select('type', $types,null , array('class' => 'form-control','id' => 'type',$required) ) !!}
   
</div>
<div class="form-group" id="category" style="display:none;">
    {!! Form::label('Category*') !!}
    {!! Form::select('category_id', $category,null , array('class' => 'form-control','id' => 'category_id') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Status*') !!}
    {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}
   
</div>
<div class="form-group">
    {!! Form::label('Url*') !!}
    {!! Form::text('url', null , array('class' => 'form-control','maxlength' => '255',$required) ) !!}

</div>
<div class="form-group last">
<div class="col-md-9">
<div class="fileinput fileinput-new" data-provides="fileinput">
    <div class="fileinput-new thumbnail" style="width: 100%; height: 150px;">
        <img src="<?php echo (isset($model))?asset('/'.$model->image):'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' ?>" alt="" /> </div>
    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
    <div>
        <span class="btn default btn-file">
            <span class="fileinput-new"> Select image </span>
            <span class="fileinput-exists"> Change </span>
            <input type="file" name="image" accept="image/*"> </span>
        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
    </div>
</div>
<div class="margin-top-10 margin-bottom-10">
    <span class="label label-danger">NOTE!</span> Best Image Size(<?php echo $size ;?>) </div>
</div>
 </div>  
<div class="clearfix"></div>
<script>
    @if(isset($model))
        @if($model->type==6)
            cat('{{$model->category_id}}');
            $("#category").show();
        @endif
    @endif
    $("#type").change(function() {
        cat($(this).val());
    });
    function cat(id)
    {
        if(id=='6')
        {
            $("#category").show();
        }
        else
        {
            $("#category").hide();
        }
    }
</script>

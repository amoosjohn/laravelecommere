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
    {!! Form::label('Name*') !!}
    {!! Form::text('name', null , array('class' => 'form-control',$required) ) !!}

</div>
<div class="form-group">
    {!! Form::label('Status*') !!}
    {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}
   
</div>
<div class="form-group">
    {!! Form::label('description') !!}
    {!! Form::textarea('description', null, ['size' => '105x10','class' => 'form-control maxlength-handler','maxlength' => '1000']) !!} 
</div>
<div class="form-group">
   {!! Form::checkbox('top', '1', null,array('class'=>'icheck','data-checkbox'=>'icheckbox_square-blue')) !!} {!! Form::label(' Top Brand') !!}
</div>
<div class="form-group">
    {!! Form::checkbox('fashion', '1', null,array('class'=>'icheck','data-checkbox'=>'icheckbox_square-blue')) !!} {!! Form::label(' Fashion Brand') !!} 
</div>
<div class="form-group">
    {!! Form::checkbox('electronic', '1', null,array('class'=>'icheck','data-checkbox'=>'icheckbox_square-blue')) !!} {!! Form::label(' Electronic Brand') !!} 
</div>

<div class="form-group last">
<div class="col-md-9">
<div class="fileinput fileinput-new" data-provides="fileinput">
    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
        <img src="<?php echo (isset($model))?asset('/'.$model->image):'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' ?>" alt="" /> </div>
    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
    <div>
        <span class="btn default btn-file">
            <span class="fileinput-new"> Select image </span>
            <span class="fileinput-exists"> Change </span>
            <input type="file" name="image" accept="image/*" <?php echo isset($model)?'':$required;?>> </span>
        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
    </div>
</div>
<div class="margin-top-10 margin-bottom-10">
    <span class="label label-danger">NOTE!</span> Best Image Size (100x100) </div>
</div>
 </div>  
<div class="clearfix"></div>

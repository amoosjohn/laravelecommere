<?php
$size = Config::get('params.best_image_size') ;
$required = "required";
?>
@include('admin/commons/errors')
<!--<div class="form-group">
    {!! Form::label('Parent Category') !!}
    {!! Form::select('parent_id', $categories,null,array('class' => 'form-control',$required)) !!}
</div>-->
<div class="form-group">
    {!! Form::label('Name') !!}<span class="required">*</span>
    {!! Form::text('name', null , array('class' => 'form-control',$required) ) !!}

</div>

<div class="form-group">
    {!! Form::label('body') !!}
    {!! Form::textarea('description', null, ['size' => '105x25','class' => 'form-control ckeditor']) !!} 
</div>
<div class="form-group">
    {!! Form::label('Commission %') !!}<span class="required">*</span>
    {!! Form::number('commission', null , array('class' => 'form-control',$required, 'pattern' => '[\-\+]?[0-9]*(\.[0-9]+)?', 'placeholder'=>'10%', 'min'=>'1') ) !!}

</div>
<!--<div class="form-group">
    {!! Form::label('teaser') !!}
    {!! Form::textarea('teaser', null, ['size' => '105x3','class' => 'form-control']) !!} 

</div>-->

<!--<div class="form-group">
    {!! Form::label('Url Keys') !!}
    {!! Form::text('key', $key , array('class' => 'form-control',$required) ) !!}
</div>-->

<div class="form-group last">
    <div class="">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width:200px; height: 200px;">
                <img src="<?php echo (isset($category)) ? asset('uploads/categories/images/' . $category->image) : asset('front/images/no-image.png') ?>" style="width: 200px; height: 200px;" alt="" /> </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
            <div>
                <span class="btn default btn-file">
                    <span class="fileinput-new"> Select image </span>
                    <span class="fileinput-exists"> Change </span>
                    <input type="file" name="image" accept="image/*" > </span>
                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
            </div>
        </div>
        <div class="margin-top-10 margin-bottom-10">
            <span class="label label-danger">NOTE!</span> Best Image Size <?php echo $size; ?> </div>
    </div>
</div> 

<div class="form-group">
    <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
    <a href="{{ url('admin/categories')}}" class="btn btn-outline grey-salsa">Cancel</a>
</div>
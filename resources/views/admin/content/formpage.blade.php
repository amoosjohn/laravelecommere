<?php
$required = "required";
$languages = Config::get('params.languages');
$types = Config::get('params.contentTypes');
?>
@include('admin/commons/errors')

<div class="form-group">
    {!! Form::label('title') !!}<span class="required">*</span>
    {!! Form::text('title', null , array('class' => 'form-control',$required) ) !!}
</div>

<div class="form-group">
    {!! Form::label('Code') !!}<span class="required">*</span>
    {!! Form::text('code', null , array('class' => 'form-control',$required) ) !!}
</div>

<div class="form-group">
    {!! Form::label('body') !!}<span class="required">*</span>
    {!! Form::textarea('body', null, ['size' => '105x25','id' => 'editor','class' => 'ckeditor',$required]) !!} 
</div>

<!--
<div class="form-group">
    {!! Form::label('teaser') !!}
    {!! Form::textarea('teaser', null, ['size' => '105x3','class' => 'form-control']) !!} 
</div>-->
<!--
<div class="form-group">
    {!! Form::label('url') !!}
    {!! Form::text('url', null , array('class' => 'form-control',$required) ) !!}
</div>
-->
<div class="form-group">
    {!! Form::label('Meta Title') !!}
    {!! Form::text('metaTitle', null , array('class' => 'form-control') ) !!}
</div>

<div class="form-group">
    {!! Form::label('Meta Description') !!}
    {!! Form::textarea('metaDescription', null, ['size' => '105x3','class' => 'form-control']) !!} 
</div>
<div class="form-group">
    {!! Form::label('keywords') !!}
    {!! Form::text('keywords', null , array('class' => 'form-control') ) !!}
</div>
<div class="form-group last">
<div class="col-md-9">
<div class="fileinput fileinput-new" data-provides="fileinput">
    <div class="fileinput-new thumbnail" style="width: 300px; height: 250px;">
        <img src="<?php echo (isset($model))?asset('/uploads/content/'.$model->image):asset('front/images/no-image.png') ?>" alt="" style="width: 100%; height: 250px;"/> </div>
    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 250px;"> </div>
    <div>
        <span class="btn default btn-file">
            <span class="fileinput-new"> Select image </span>
            <span class="fileinput-exists"> Change </span>
            <input type="file" name="image" accept="image/*"> </span>
        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
    </div>
</div>
<!--<div class="margin-top-10 margin-bottom-10">
    <span class="label label-danger">NOTE!</span> Best Image Size (100x100) </div>-->
</div>
 </div>  
<div class="clearfix"></div>
<!--
<div class="form-group">
    {!! Form::label('Banner') !!}
    {!! Form::file('image', null,array($required,'class'=>'form-control')) !!}
</div>
-->
<div class="form-group">
    <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
    <a href="{{ url('admin/content')}}" class="btn btn-outline grey-salsa">Cancel</a>
</div>
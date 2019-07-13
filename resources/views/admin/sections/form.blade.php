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
.category__list{
    list-style: none;
}
.portlet-body {
    height: 450px;
    overflow-y: scroll;
}
</style>
<?php
$size = Config::get('params.best_image_size') ;
$required = "required";
?>
@include('admin/commons/errors')
<div class="form-group">
    {!! Form::label('Type*') !!}
    {!! Form::select('type', $types,null , array('class' => 'form-control',$required) ) !!}
   
</div>
<div class="form-group">
    {!! Form::label('Status*') !!}
    {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}
   
</div>
<div class="form-group">
    {!! Form::label('Category*') !!}
    {!! Form::select('category', $categories,null , array('class' => 'form-control select2me','id' => 'category',$required) ) !!}
   
</div>
<section class="category-area theme-blue clrlist">
   
        <div class="row">
            <div class="category__lft col-sm-4">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold ">Check categories to show</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                     <ul class="category__list" id="result">
                        
                    </ul>
                  </div>
                </div>
            </div>
            <div class="category__rgt col-sm-8">
                <div class="category__cont p0 col-sm-12">
                    <div class="col-sm-5">
                       <div class="form-group last">
                               <div class="fileinput fileinput-new" data-provides="fileinput">
                                   <div class="fileinput-new thumbnail" style="width: 300px; height: 400px;">
                                       <img src="<?php echo (isset($model)) ? asset('/' . $model->image) : '' ?>" alt="" /> </div>
                                   <div class="fileinput-preview fileinput-exists thumbnail" style="width: 300px; height: 400px;"> </div>
                                   <div>
                                       <span class="btn default btn-file">
                                           <span class="fileinput-new"> Select image </span>
                                           <span class="fileinput-exists"> Change </span>
                                           <input type="file" name="image" accept="image/*"> </span>
                                       <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                   </div>
                               </div>
                               <div class="margin-top-10 margin-bottom-10">
                                   <span class="label label-danger">NOTE!</span> Best Image Size(400X500) </div>
                           
                                   
                       </div>
                        <div class="form-group">
                            {!! Form::text('url', null , array('class' => 'form-control','placeholder'=>'Enter Url','maxlength' => '255') ) !!}
                        </div>
                    </div>
                    <div class="category__products p0 col-sm-7">
                        <div class="col-sm-6">
                        <div class="form-group last">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 140px;">
                                    <img src="<?php echo (isset($model)) ? asset('/' . $model->image2) : '' ?>" alt="" style="width: 200px; height: 140px;"/> </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 140px;"> </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="image2" accept="image/*"> </span>
                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                            <div class="margin-top-10 margin-bottom-10">
                                Image Size <span class="label label-danger">(240X140)</span></div>
                        </div>
                            <div class="form-group">
                                {!! Form::text('title2', null , array('class' => 'form-control','placeholder'=>'Enter Title','maxlength' => '255') ) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('short2', null , array('class' => 'form-control','placeholder'=>'Enter Short Desc','maxlength' => '255') ) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('url2', null , array('class' => 'form-control','placeholder'=>'Enter Url','maxlength' => '255') ) !!}
                            </div>
                            
                        </div>
                        <div class="products__box col-sm-6">
                            <div class="form-group last">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 140px;">
                                        <img src="<?php echo (isset($model)) ? asset('/' . $model->image3) : '' ?>" alt="" style="width: 200px; height: 140px;"/> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 140px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="image3" accept="image/*"> </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="margin-top-10 margin-bottom-10">
                                    Image Size <span class="label label-danger">(240X140)</span></div>
                            </div>
                            <div class="form-group">
                                {!! Form::text('title3', null , array('class' => 'form-control','placeholder'=>'Enter Title','maxlength' => '255') ) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('short3', null , array('class' => 'form-control','placeholder'=>'Enter Short Desc','maxlength' => '255') ) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('url3', null , array('class' => 'form-control','placeholder'=>'Enter Url','maxlength' => '255') ) !!}
                            </div>
                            
                        </div>
                        <div class="products__box col-sm-6">
                            <div class="form-group last">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 140px;">
                                        <img src="<?php echo (isset($model)) ? asset('/' . $model->image4) : '' ?>" alt="" style="width: 200px; height: 140px;"/> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 140px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="image4" accept="image/*"> </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="margin-top-10 margin-bottom-10">
                                    Image Size <span class="label label-danger">(240X140)</span></div>
                            </div>
                            <div class="form-group">
                                {!! Form::text('title4', null , array('class' => 'form-control','placeholder'=>'Enter Title','maxlength' => '255') ) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('short4', null , array('class' => 'form-control','placeholder'=>'Enter Short Desc','maxlength' => '255') ) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('url4', null , array('class' => 'form-control','placeholder'=>'Enter Url','maxlength' => '255') ) !!}
                            </div>
                            
                        </div>
                        <div class="products__box col-sm-6">
                            <div class="form-group last">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 140px;">
                                        <img src="<?php echo (isset($model)) ? asset('/' . $model->image5) : '' ?>" alt="" style="width: 200px; height: 140px;"/> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 140px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="image5" accept="image/*"> </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="margin-top-10 margin-bottom-10">
                                    Image Size <span class="label label-danger">(240X140)</span></div>
                            </div>
                            <div class="form-group">
                                {!! Form::text('title5', null , array('class' => 'form-control','placeholder'=>'Enter Title','maxlength' => '255') ) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('short5', null , array('class' => 'form-control','placeholder'=>'Enter Short Desc','maxlength' => '255') ) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('url5', null , array('class' => 'form-control','placeholder'=>'Enter Url','maxlength' => '255') ) !!}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>

<!--
<div class="form-group">
    {!! Form::label('Title') !!}
    {!! Form::text('title', null , array('class' => 'form-control','maxlength' => '255') ) !!}

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
-->
<script>
@if(isset($model))
    getCat('{{$model->category}}','{{$model->category2}}','{{$model->category3}}')
@endif    
function getCat(id,category2='',category3='')
{
    var url='';
    if(category2!='') {
        url = 'category2='+category2;
    }
    if(category3!='') {
        url += '&category3='+category3;
    }
    $.ajax({
            type: "GET",
            url: "{{ url('admin/sections') }}/"+id,
            data:url,
            success: function(data){
                $('#result').html(data);
            },
            error: function(errormessage) {
            //you would not show the real error to the user - this is just to see if everything is working
            //alert(errormessage);
            }
    });
}
$("body").on("change","#category",function(){
    
    getCat($(this).val());
});
    $(".child[type='checkbox']").click(function(){
    if($(this).is(':checked')){
      $(this).closest('li.parent').find('.parent').prop("checked",true);
    }
    /*else{
      $(this).closest('li.parent').find('.parent').prop("checked",false);
    }*/
});

$(".parent[type='checkbox']").click(function(){
    if($(this).is(':checked')){
      $(this).parent('li').find('.child').prop("checked",true);
    }else{
      $(this).parent('li').find('.child').prop("checked",false);
    }
});
</script>
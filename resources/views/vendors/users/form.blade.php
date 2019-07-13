<?php
$required = "required";
?>
@include('vendors/commons/errors')
<div class="form-group">
    {!! Form::label('Full Name') !!}<span class="required"> * </span>
    {!! Form::text('firstName', null, array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('email') !!}
    <span class="required"> * </span>
    {!! Form::email('email', null , array('class' => 'form-control',$required) ) !!}
</div>
<div class="form-group">
    {!! Form::label('Password') !!}
    <?php echo (!isset($model))?'<span class="required"> * </span>':'' ?>
    {!! Form::password('password' , array('class' => 'form-control',(!isset($model))?$required:'') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Confirm Password') !!}
    <?php echo (!isset($model))?'<span class="required"> * </span>':'' ?>
    {!! Form::password('password_confirmation' , array('class' => 'form-control',(!isset($model))?$required:'') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Status') !!}
    <span class="required"> * </span>
    {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}
   
</div>
<div class="form-group">
    {!! Form::label('Gender') !!}
    <span class="required"> * </span>
    @if(isset($model))
    <?php $gender = $model->gender; ?>
    @else
    <?php $gender = old('gender'); ?>
    @endif
    <select class="form-control gender" name="gender" required="required">
        <option value=''>Select</option>
        <option value="Male" {{ ($gender=='Male') ? 'selected' : '' }}>Male</option>
        <option value="Female" {{ ($gender=='Female') ? 'selected' : '' }}>Female</option>
    </select>
</div>
<div class="form-group">
    {!! Form::label('Date of Birth') !!}
    {!! Form::text('dob', null, array('class' => 'form-control','id' => 'dob') ) !!}
</div>
<div class="form-group">
    {!! Form::label('Mobile No.') !!}
    {!! Form::text('mobile', null, array('class' => 'form-control','id' => 'mobile') ) !!}
</div>
<div class="clearfix"></div>
<h3>User Permissions</h3>
<div class="col-sm-10">
    <ul style="list-style: none;">
        @foreach($permissions as $permission)
        
        @if($permission->parent_id=='')
        <li class="parent">
            <input type="checkbox" name="permission_id[]" value="{{ $permission->id }}" id="{{ $permission->id }}" class="parent"  onchange="fnTest(this);" 
            @if(isset($userPermissions))
            @foreach($userPermissions as $userPer)
            @if($userPer->permission_id==$permission->id)
            <?php echo 'checked'; ?>
            @else
            <?php echo ''; ?>
            @endif
            @endforeach
            @endif/><label for="{{ $permission->id }}"> {{ $permission->description }}</label>
            <ul>
                @endif
                @foreach($permission->children as $child)

                <li><input type="checkbox" name="permission_id[]" value="{{ $child->id }}" id="{{ $child->id }}" class="child" 
            @if(isset($userPermissions))
            @foreach($userPermissions as $userPer)
            @if($userPer->permission_id==$child->id)
            <?php echo 'checked'; ?>
            @else
            <?php echo ''; ?>
            @endif
            @endforeach
            @endif><label for="{{ $child->id }}"> {{ $child->description }}</label>
                </li>

                @endforeach
            </ul>
        

            @endforeach  
    </ul>
</div>   
<script>
    $("#dob").keydown(function(event) { 
      return false;
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
    }
    else{
      $(this).parent('li').find('.child').prop("checked",false);
    }
});
</script>


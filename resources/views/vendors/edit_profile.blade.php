@extends('vendors/vendor_template')

<?php
$size = Config::get('params.best_image_size') ;
$required = "required";
?>
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Update Profile</h3>
            </div>
       @include('vendors.commons.errors')
        <div class='box-body'>
         {!! Form::model($edit_info, ['files' => true,'class' => 'update_myinfo','url' => ['vendor/info_updated', $edit_info->id], 'method' => 'post']) !!}
             
              <div class="form-group">
                <label for="firstName">Company Name:</label><label style="color:red;">*</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="{{$edit_info->firstName}}" <?php echo $required ?>>
              </div>
               
             <div class="form-group">
                <label for="email">Email:</label><label style="color:red;">*</label>
                <input type="email" class="form-control" id="email" name="email" value="{{$edit_info->email}}" <?php echo $required ?>>
              </div>
             <div class="form-group">
                 {!! Form::label('password') !!}
                 {!! Form::password('password' , array('class' => 'form-control') ) !!}
             </div> 
             <div class="form-group">
                 {!! Form::label('confirm password') !!}
                 {!! Form::password('password_confirmation' , array('class' => 'form-control') ) !!}
             </div>
              <div class="form-group">
                <label for="address">Address:</label><label style="color:red;">*</label>
                <input type="text" class="form-control" id="address" name="address" value="{{$edit_info->address}}" <?php echo $required ?>>
              </div>
             
              <div class="form-group">
                <label for="postal_code">Postal Code:</label><label style="color:red;">*</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{$edit_info->postal_code}}" <?php echo $required ?>>
              </div>
             
             <div class="form-group">
                 {!! Form::label('Region') !!}<label style="color:red;">*</label>
                 {!! Form::select('region', $regions,$edit_info->region , array('class' => 'form-control','id' => 'region',$required) ) !!}
             </div>
             <div class="form-group">
                 {!! Form::label('city') !!}<label style="color:red;">*</label>
                 <select class="form-control" name="city" id="city" <?php echo $required ?>>
                     <option value="">Select City*</option>
                 </select> 
             </div>
             
              <div class="form-group">
                <label for="coutry">Mobile No:</label><label style="color:red;">*</label>
                <input type="number" class="form-control" id="mobile" name="mobile" value="{{$edit_info->mobile}}" <?php echo $required ?>>
              </div>
             
              <div class="form-group">
                  <div class="row">
                    
                      <div class="col-sm-6">
                           <label for="logo">Change Logo:</label>
                        <div>
                            <input type="file" class="form-control" id="logo" name="logo" value="">
                        </div>
                          
                      </div>
                     @if($edit_info->logo!='')
                      <div class="col-sm-4">
                        <label>Logo:</label>
                        <div>
                            <img src="{{asset('uploads/vendors_logo/'.$edit_info->logo)}}" width="40%">
                        </div>
                    </div>
                      @endif
                  </div>
              </div>
                <div class="form-group">
                    {!! Form::label('Contact Person') !!}
                    {!! Form::text('contactPerson', null , array('class' => 'form-control') ) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Designation') !!}
                    {!! Form::text('designation', null , array('class' => 'form-control') ) !!}
                </div>
              <h3 class="box-title">Bank Account Details</h3>
             <div class="form-group">
                <label for="title">Bank Account Title </label><label style="color:red;">*</label>
                {!! Form::text('title',isset($edit_info->bankaccount)?$edit_info->bankaccount->title:null , array('class' => 'form-control',$required) ) !!}
             </div>
             <div class="form-group">
                <label for="number">Bank Account Number </label><label style="color:red;">*</label>
                {!! Form::text('number',isset($edit_info->bankaccount)?$edit_info->bankaccount->number:null , array('class' => 'form-control',$required) ) !!}
             </div>
              <div class="form-group">
                <label for="number">Bank Name </label><label style="color:red;">*</label>
                {!! Form::select('bankName', $bankNames,isset($edit_info->bankaccount)?$edit_info->bankaccount->bankName:null , array('class' => 'form-control',$required) ) !!}
             </div>
              <div class="form-group">
                <label for="number">Branch Code </label><label style="color:red;">*</label>
                {!! Form::text('branchCode',isset($edit_info->bankaccount)?$edit_info->bankaccount->branchCode:null , array('class' => 'form-control',$required) ) !!}
             </div>
             <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
                    <a href="{{ url('vendor/view-profile')}}" class="btn btn-outline grey-salsa">Cancel</a>
            </div>
               
           {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
</section>
<script>
    $(document).ready(function () {
        $(".select").select();
    });
@if(isset($edit_info))
    getCities('{{ $edit_info->region }}','{{ $edit_info->city }}');
@endif    
function getCities(id,city='')
{
var send = 'region=' + id;
if(city!='')
{
    var send = 'region=' + id + '&city=' + city;
}
$.ajax({
        type: "GET",
        url: "{{ url('checkout/cities') }}",
        data: send,
        success: function(response){
        $('#city').html(response);
        },
        error: function(errormessage) {
        //you would not show the real error to the user - this is just to see if everything is working
        
        }
});
}
$("body").on("change","#region",function(){
    var region = $(this).val();
    getCities(region);
});
</script>
@endsection

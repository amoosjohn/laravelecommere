@extends('vendors/vendor_template')

<?php
$size = Config::get('params.best_image_size') ;
$required = "required";
?>
@section('content')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach
</div> <!-- end .flash-message -->
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Add New User
                </h3>
            </div>
        <div class="box-body">
            <div class='contacts'>
           {!! Form::open(array( 'class' => 'form','url' => 'vendor/users/store', 'files' => true)) !!}
           @include('vendors.users.form')  
           <div class="form-group">
               <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
               <a href="{{ url('vendor/users')}}" class="btn btn-outline grey-salsa">Cancel</a>
           </div>
               
           {!! Form::close() !!}
                
            </div>
        </div>
        
        
     </div>
        <!-- /.box -->
    </div>
</div>


<script>
jQuery(document).ready(function(){
   
     $( "#dob" ).datepicker({
        format: "yyyy-mm-dd",
        changeMonth: true,
        changeYear: true
      });

   
      
    
});


</script>




@endsection
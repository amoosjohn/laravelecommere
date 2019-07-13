@extends('vendors/vendor_template')

@section('content')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach
</div> <!-- end .flash-message -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        View Vendor's Details
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">My Profile</li>
        <li class="active">View Profile</li>
        
    </ol>
     
</section>

<!-- Main content -->
<section class="content">

    <!-- Small boxes (Stat box) -->
    <!-- BEGIN DASHBOARD STATS 1-->
   
    <div class="row">
        @include('vendors.commons.errors')
       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
           <table class="cust-table">
             @foreach($myinfo as $info)
             <div class="row">
                 <div class="col-sm-6">
                     <label for="email"><b>Name</b></label>
                 </div>
                 <div class="col-sm-6">
                     <span>{{ $info->firstName }}</span>
                 </div>
              </div>
             
             <div class="row">
                 <div class="col-sm-6">
                          <label>Email Address</label>
                 </div>
                 <div class="col-sm-6">
                     <span>{{ $info->email }}</span>
                 </div>
              </div>
             
              <div class="row">
                 <div class="col-sm-6">
                          <label>Address</label>
                 </div>
                 <div class="col-sm-6">
                     <span>{{ $info->address }}</span>
                 </div>
               
              </div>
              <div class="row">
                 <div class="col-sm-6">
                          <label>Postal Code</label>
                 </div>
                 <div class="col-sm-6">
                     <span>{{ $info->postal_code }}</span>
                 </div>
               
              </div>
             <div class="row">
                 <div class="col-sm-6">
                          <label>Region</label>
                 </div>
                 <div class="col-sm-6">
                     <span>{{(count($info->regions)>0)?$info->regions->name:''}}</span>
                 </div>
              </div>
             <div class="row">
                 <div class="col-sm-6">
                          <label>City</label>
                 </div>
                 <div class="col-sm-6">
                     <span>{{ (count($info->cities)>0)?$info->cities->name:'' }}</span>
                 </div>
              </div>
              <div class="row">
                 <div class="col-sm-6">
                          <label>Mobile</label>
                 </div>
                 <div class="col-sm-6">
                     <span>{{ $info->mobile }}</span>
                 </div>
              </div>
             
             <div class="row">
                 <div class="col-sm-6">
                          <label>logo</label>
                 </div>
                 <div class="col-sm-6">
                     <img src="{{asset('uploads/vendors_logo/'.$info->logo)}}" width="35%">
                 </div>
             </div>
             
             <div class="row">
                 <div class="btn-group pull-left">
                    <a href="{{  url('vendor/info_edit',Auth::user()->id) }}" class="btn sbold green"> 
                        <i class="fa fa-pencil"></i> Edit
                    </a>
                     
                </div>
             </div>
              
              
             @endforeach
           </table>
           </div>
        
       
        
        
    </div>
     
    
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    
   
   
</section>  

<style>
    .row{
        margin: 10px;
    }
    
    
    
</style> 
@endsection
@extends('vendors/vendor_template')

@section('content')   
<!-- Main row -->
<h1 class="page-title">Vendor's Users</h1>
<div class="row">
<div class="col-md-12">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><i class="icon fa fa-check"></i> &nbsp  {!! session('success') !!}</p>
        </div>
    @endif
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-social-dribbble font-green"></i>
                <span class="caption-subject font-green bold uppercase"> ( Total Contact : {{count($totalcontacts)}}  )  </span>
            
            </div>
            <!--<div class="btn-group pull-right">
                <a href="#" class="btn sbold green"> Add Contact
                <i class="fa fa-plus"></i>
            </a>
            </div>-->
        </div>
        <div class="portlet-body">
            <div class='table-scrollable'>
              
             <?php
               
            if(count($totalcontacts)!=0)
            {
            ?>
            <table class="cust-table">
                 <tr>
                    <th width="10%">S.no</th>
                    <th width="10%">Name</th>
                    <th width="10%">Email</th>
                    <th width="10%">Address</th>
                    <th width="10%">Mobile No</th>
<!--                <th width="10%">Actions</th>-->
                 </tr>
                 <tbody>
                    <?php $i = 1; ?>
                    @foreach($totalcontacts as $value)
                     <tr>
                        <td width="10%">{{$i}}</td>
                        <td width="20%">{{$value->firstName}}</td>
                        <td width="20%">{{$value->email}}</td>
                        <td width="30%">{{$value->address}}</td>
                        <td width="20%">{{$value->mobile}}</td>
<!--                        <td width="">
                            <div><a href="{{ url('vendor') }}" class="btn btn-primary">Update</a></div><br>
                            <div> <a href="{{ url('vendor') }}" class="btn btn-danger    ">Delete</a></div>
                            
                        </td>-->
                     </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            
            </table>
            
            
            <?php
            }
            else
            {
                echo 'No Any Contact Person...';
            }
                
            
            ?>
                 
             </div>
            
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>
</div>
</section>

@endsection
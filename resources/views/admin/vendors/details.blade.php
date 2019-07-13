@extends('admin/admin_template')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
          <h4>View Vendor's Details</h4>

    </div>
    <div class="panel-body">
        <div class='vendor_info'>
            <table class="cust-table">
                <tr>
                    <th width="30%">First Name</th><td>:</td><td width="60%">{{ $vendor_detail->firstName }}</td>
                </tr>
               <tr>
                    <th width="30%">Email Address</th><td>:</td><td width="60%">{{ $vendor_detail->email }}</td>
                </tr>
                 <tr>
                    <th width="30%">Address</th><td>:</td><td width="60%">{{ $vendor_detail->address }}</td>
                </tr>
                 <tr>
                    <th width="30%">Postal Code</th><td>:</td><td width="60%">{{ $vendor_detail->postal_code }}</td>
                </tr>
                <tr>
                    <th width="30%">Region</th><td>:</td><td width="60%">{{ (count($vendor_detail->regions)>0)?$vendor_detail->regions->name:'' }}</td>
                </tr>
                 <tr>
                    <th width="30%">City</th><td>:</td><td width="60%">{{ (count($vendor_detail->cities)>0)?$vendor_detail->cities->name:'' }}</td>
                </tr>
                 
                 <tr>
                    <th width="30%">Mobile</th><td>:</td><td width="60%">{{ $vendor_detail->mobile }}</td>
                </tr>
                 <tr>
                     <th width="30%">logo</th><td>:</td><td width="60%"><img src="{{asset('uploads/vendors_logo/'.$vendor_detail->logo)}}" width="35%"></td>
                </tr>
                <tr>
                    <th>Created date</th><td>:</td><td width="60%">{{ $vendor_detail->created_at }}</td>
                </tr>
                <tr>
                    <th>Updated date</th><td>:</td><td width="60%">{{ $vendor_detail->updated_at }}</td>
                </tr>


            </table>
        </div>
        <div class='vendor_contact'>
            <h4>Vendor's Contacts Detail</h4>
            <table class="cust-table">
                <tr>
                    <th width="30%">Contact Person</th><td>:</td><td width="60%">{{ $vendor_detail->contactPerson }}</td>
                </tr>
               <tr>
                    <th width="30%">Designation</th><td>:</td><td width="60%">{{ $vendor_detail->designation }}</td>
                </tr>
                


            </table>
            
        </div><br>
         <a href="{{ url('admin/vendors') }}" class="btn btn-primary">Back</a>
    </div>            
         
</div>

@endsection
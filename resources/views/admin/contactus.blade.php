@extends('admin/admin_template')

@section('content')
<?php 
use App\Functions\Functions;
?>
<!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
  <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Contacts( Total : {{ count($contactus) }} ) </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <ul class="products-list product-list-in-box">				
				<table class="table table-striped">
            	<thead>
                	<tr>     
                    	<td>Name</td>
                        <td>Email</td>
                        <td>Message</td>
			<td>Added</td>
                        <td>Action</td>                                    
                    </tr>
                </thead>
                <tbody>
                @foreach($contactus as $contacts)
                	<tr>                  
                    	<td>{{ $contacts->name }}</td>
                        <td>{{ $contacts->email}}</td>
                        <td><?php echo Functions::stringTrim($contacts->message,40,0,40) ?></td>
                        <td>{{ date('d M Y',strtotime($contacts->created_at))}}</td>
                        <td><a href="contactusdetail/{{$contacts->id}}" class="btn btn-info">Detail</a></td>                                    
                    </tr>
                @endforeach 
                </tbody>
            </table>
            
              </ul>
            <?php echo $contactus->render(); ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="javascript::;" class="uppercase"></a>
            </div>
            <!-- /.box-footer -->
          </div>
	</div>
    <!-- /.col -->
</div>
<!-- /.row -->	

@endsection
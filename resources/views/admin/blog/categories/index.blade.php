@extends('admin/admin_template')

@section('content')
   

<!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
  <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Blog Categories( Total : {{ count($categories) }} ) </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
				
				<?php $i=1; ?>
				@foreach ($categories as $row)
				
				<?php	
					$color = ($i % 2 ==0 ? 'success' : 'info'); 					
				?>
				
			    <li class="item">
                    <div class="product-img">
                    <img src="{{ asset('uploads/blog/categories/thumbnail')}}/<?php echo $row->image; ?>" alt="<?php  echo $row->name; ?>" />
                    <br />
                    <a href="blog/categories/delete/<?php echo $row->id?>">Delete</a>
                 
                  </div>
                
                  <div class="product-info">
                    <a href="blog/categories/edit/<?php echo $row->id?>" class="product-title"><?php  echo $row->name; ?>
                    <span class="label label-<?php echo $color; ?> pull-right"><?php  echo $row->created_at; ?></span></a>
                        <span class="product-description">
                          <?php  echo substr($row->description,0,30); ?>
                        </span>
                        
                  </div>
                </li>
                <!-- /.item -->
				<?php $i++; ?>
				@endforeach
				
              </ul>
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
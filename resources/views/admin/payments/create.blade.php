@extends('admin/admin_template')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <h3 class="box-title">Add New Payment</h3>
            </div>
      
            <!-- /.box-header -->
            <div class="portlet-body">
            {!! Form::open(array( 'class' => 'form','url' => 'admin/payments', 'files' => true)) !!}
               <?php $page='admin.payments.form'?>
               @include($page)    
              <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                    <a href="{{ url('admin/payments')}}" class="btn btn-outline grey-salsa">Cancel</a>
            </div>
             {!! Form::close() !!}
                
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection
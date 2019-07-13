@extends('vendors/vendor_template')
@section('content')
<?php
use App\Functions\Functions;
?>
<style>
.stars-rating{
    float: left;
    margin-right: 0;
    margin-bottom: 10px;
}

.stars__container ul li i.fa-star{
	color:#ffdc2e;
}
.stars__container ul li i.fa-star-o{
	color:#848585;
}
.stars__container ul li {
    list-style: none;
    display: inline-block;
}
.stars__container ul {
    margin-left: 0 !important;
    padding: 0;
}
</style>
<!-- Main row -->
<h1 class="page-title">Reviews</h1>
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
                <span class="caption-subject font-green bold uppercase"> Total Reviews : {{ $model->total() }}  </span>
            
            </div>
        </div>
        <div class="portlet-body">
          
            <div class="table-scrollable">
                <table class="table table-hover" data-toggle="dataTable" data-form="deleteForm">
                    <thead>
                        <tr>
                            <th style="width:  20%;"> Product </th>
                            <th style="width:  10%;"> Customer Name </th>
                            <th style="width:  10%;"> Name or Nickname </th>
                            <th style="width:  10%;"> Ratings </th>
                            <th style="width:  10%;"> Date </th>
                            <th style="width:  10%;"> Status </th>
                            <th style="width:  10%;"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($model)>0)
                        @foreach($model as $row)
                        <?php
                            $status = '';
                            $color = '';
                            if (array_key_exists($row->status, $statuses)) {
                               $status = $statuses[$row->status];
                            }
                            if (array_key_exists($row->status, $colors)) {
                               $color = $colors[$row->status];
                            }
                        ?>
                        <tr>
                            <td>{{ $row->productName }}</td>
                            <td>{{ (count($row->users)>0)?$row->users->firstName:'' }}</td>
                            <td>{{ $row->name }}</td>
                            <td><div class="stars-rating">
                                 <div class="stars__container">
                                <ul>
                                    @for($i=1;$i<=5;$i++)
                                    <li><i class="fa fa-star<?php echo ($row->ratings >= $i) ? '' : '-o'; ?>"></i></li>
                                    @endfor
                                </ul>
                                </div>
                                </div>
                             </td>
                            <td>{{ Functions::frontDate($row->created_at)}}</td>

                            <td class="{{ $color }} sbold"><i class="fa fa-circle"></i> {{ $status }}</td>
                            <td>
                                <a href="<?php echo url('product/' . $row->link); ?>" class="btn dark btn-sm" title="View product details on site" target="_blank"><i class="fa fa-globe"></i>
                                </a>
                                <a href="<?php echo url('vendor/reviews/'.$row->id.'/edit'); ?>" class="btn btn-primary btn-sm" title="Change Status"><i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3" class="text-center">Data not found!</td>
                           
                        </tr>
                        @endif
                    </tbody>
                </table>
        <?php echo $model->render(); ?>   
        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this review?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete-btn">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
       
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>
</div>
<!-- /.row -->
@endsection

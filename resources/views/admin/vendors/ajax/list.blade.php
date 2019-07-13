<?php use App\Urls; ?>
<table class="table table-hover" data-toggle="dataTable" data-form="deleteForm">
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
$url = Urls::getUrl($row->id, 'vendor');
?>
<tr>
    <td style="width:  5%;">{{ $row->id }}</td>
    <td style="width: 15%;">{{ $row->firstName }}</td>
    <td style="width: 15%;">{{ $row->email }}</td>
    <td style="width: 10%;" class="{{ $color }} sbold"><i class="fa fa-circle"></i> {{ $status }}</td>
    <td style="width: 10%;"><?php echo date("d M Y", strtotime($row->created_at)); ?></td>
    <td style="width: 15%;">
        <a data-href="{{ url('admin/vendor/status/'.$row->id) }}" data-target="#confirm-status" class="btn btn-info btn-sm"  data-toggle="modal"  title="Change Status"><i class="fa fa-user"></i></a>
        @if(count($url)>0)
        <a href="{{ url('seller/' . $url->key) }}" class="btn dark btn-sm" title="View vendor product on site" target="_blank"><i class="fa fa-globe"></i></a>
        @endif
        <a href="{{ url('admin/vendor-details/'.$row->id) }}"  class="btn btn-success btn-sm"><i class="fa fa-table"></i></a>
        <a href="{{ url('admin/vendor/edit/'.$row->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
        <a data-href="{{ url('admin/vendor/delete/'.$row->id) }}" data-target="#confirm-delete" class="btn btn-danger btn-sm delete "  data-toggle="modal"  title="Delete"><i class="fa fa-trash"></i></a>
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="6" class="text-center">Data not found!</td>

</tr>
@endif
</tbody>
</table>
<div><?php echo "Showing ".$model->count()." of ".$model->total(); ?></div>
<?php echo $model->appends(Input::except('page'))->links();?>
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this customer?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete-btn">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

<script>
 $('table[data-form="deleteForm"]').on('click', '.form-delete', function(e){
    e.preventDefault();
    var $form=$(this);
    $('#confirm').modal({ backdrop: 'toggle', keyboard: false })
        .on('click', '#delete-btn', function(){
            $form.submit();
        });
});
</script>
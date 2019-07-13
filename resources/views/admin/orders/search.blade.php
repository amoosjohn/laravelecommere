<?php
use App\Functions\Functions;
?>
<table class="table table-striped table-bordered  table-checkable  no-footer"  data-form="deleteForm">
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
if (array_key_exists($row->vendorStatus, $vendorStatus)) {
    $venStatus = $vendorStatus[$row->vendorStatus];
}
?>
<tr>
    <td style="width: 10%;">{{ $row->id }}</td>
    <td style="width: 15%;">{{ Functions::dateFormat($row->created_at) }}</td>
    <td style="width: 15%;">{{ ($row->firstName!='')?$row->firstName." ".$row->lastName:$row->gFirstName." ".$row->gLastName }}</td>
    <td style="width: 10%;">{{ $row->totalQuantity }}</td>
    <td style="width: 15%;">{{ $symbol.".".Functions::moneyFormat($row->grandTotal) }}</td>
    <td style="width: 10%;">{{ $venStatus }}</td>
    <td style="width: 10%;"><span class="{{ $color }} sbold">{{ $status }}</span></td>
    <td style="width: 10%;">
        <a href="<?php echo url('admin/orders/' . $row->id); ?>" class="btn dark btn-sm" title="View order details"><i class="fa fa-eye"></i>
        </a>
        {!! Form::open(array('url' => 'admin/orders/' .$row->id,'class'=>'form-inline form-delete','id'=>'delete')) !!}
        {!! Form::hidden('_method', 'DELETE') !!}
        <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete" title="Delete"><i class="fa fa-trash"></i> </button>
        {!! Form::close() !!}
     

    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="9" class="text-center">Data not found!</td>

</tr>
@endif
</tbody>
</table>
<?php echo $model->appends(Input::except('page'))->links();?>
<div><?php echo "Showing ".$model->count()." of ".$model->total(); ?></div>
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this order?</p>
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
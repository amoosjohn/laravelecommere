<table class="table table-hover" data-toggle="dataTable" data-form="deleteForm">
<tbody>
@if(count($model)>0)
@foreach($model as $key=>$row)
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
    <td style="width:  8%;">{{ $row->id }}</td>
    <td style="width: 15%;">{{ $row->firstName }}</td>
    <td style="width: 15%;">{{ $row->lastName }}</td>
    <td style="width: 15%;">{{ $row->email }}</td>
    <td style="width: 10%;" class="{{ $color }} sbold"><i class="fa fa-circle"></i> {{ $status }}</td>
    <td style="width: 10%;"><?php echo date("d M Y", strtotime($row->created_at)); ?></td>
    <td style="width: 10%;">
    <a data-href="{{ url('admin/customer/status/'.$row->id) }}" data-target="#confirm-status" class="btn btn-info btn-sm"  data-toggle="modal"  title="Change Status"><i class="fa fa-user"></i></a>
    <a href="<?php echo url('admin/customers/' . $row->id); ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
    </a>
    {!! Form::open(array('url' => 'admin/customers/' .$row->id,'class'=>'form-inline form-delete','id'=>'delete')) !!}
    {!! Form::hidden('_method', 'DELETE') !!}
    <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete" title="Delete"><i class="fa fa-trash"></i> </button>
    {!! Form::close() !!}
     

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
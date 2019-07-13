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
    $method = '';
    if (array_key_exists($row->status, $statuses)) {
        $status = $statuses[$row->status];
    }
    if (array_key_exists($row->status, $colors)) {
        $color = $colors[$row->status];
    }
    if (array_key_exists($row->method, $methods)) {
        $method = $methods[$row->method];
    }
    ?>
    <tr>
        <td style="width: 10%;">{{ (count($row->users)>0)?$row->users->firstName:'' }}</td>
        <td style="width: 10%;">{{ $symbol.'.'.Functions::moneyFormat($row->amount) }}</td>
        <td style="width: 10%;">{{ $method }}</td>
        <td style="width: 10%;">{{ $row->number }}</td>
        <td style="width: 10%;">{{ Functions::dateFormat($row->date)}}</td>
        <td style="width: 10%;">{{ $row->receivedBy }}</td>
        <td style="width: 10%;">
            <a href="<?php echo url('admin/payments/' . $row->id . '/edit'); ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i>
            </a>
            {!! Form::open(array('url' => 'admin/payments/' .$row->id,'class'=>'form-inline form-delete','id'=>'delete')) !!}
            {!! Form::hidden('_method', 'DELETE') !!}
            <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete" title="Delete"><i class="fa fa-trash"></i> </button>

            {!! Form::close() !!}

        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="8" class="text-center">Data not found!</td>

    </tr>
    @endif
</tbody>
</table>
<?php echo $model->appends(Input::except('page'))->links();?>
<div><?php echo "Showing ".$model->count()." of ".$model->total(); ?></div>
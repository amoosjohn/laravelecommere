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
$venStatus = '';
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
    <td style="width: 10%;">{{ Functions::dateFormat($row->created_at) }}</td>
    <td style="width: 10%;">{{ ($row->firstName!='')?$row->firstName." ".$row->lastName:$row->gFirstName." ".$row->gLastName }}</td>
    <td style="width: 10%;">{{ $row->totalQuantity }}</td>
    <td style="width: 10%;">{{ $symbol.".".Functions::moneyFormat($row->grandTotal) }}</td>
    <td style="width: 10%;">{{ $venStatus }}</td>
    <td style="width: 10%;"><span class="{{ $color }} sbold">{{ $status }}</span></td>
    <td style="width: 10%;">
        @if(Auth::user()->role_id==3 || $permission2>0)
        <a href="<?php echo url('vendor/orders/' . $row->id); ?>" class="btn dark btn-sm" title="View order details"><i class="fa fa-eye"></i>
        </a>
        @endif
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

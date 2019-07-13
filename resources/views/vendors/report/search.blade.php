<?php
use App\Functions\Functions;
use App\Orders;
?>
<table class="table table-striped table-bordered  table-checkable  no-footer"  data-form="deleteForm">
<tbody>
@if(count($model)>0)
@foreach($model as $row)
<?php
$outstanding = 0; 
$totalCommission = 0;
$payAmount = 0;
$pay = Orders::report('',$row->id);

if(count($pay['commission'])>0) {
    $totalCommission = $pay['commission']->totalCommission;
}
if(count($pay['payment'])>0) {
    $payAmount = $pay['payment']->payAmount;
}
$outstanding = $row->orderAmount - $totalCommission - $payAmount;
?>
<tr>
    <td style="width: 10%;">{{ ($row->firstName!='')?$row->firstName:'' }}</td>
    <td style="width: 10%;">{{ Functions::moneyFormat($row->orderAmount) }}</td>
    <td style="width: 10%;">{{ Functions::moneyFormat($totalCommission) }}</td>
    <td style="width: 10%;">{{ Functions::moneyFormat($payAmount) }}</td>
    <td style="width: 10%;">{{ Functions::moneyFormat($outstanding) }}</td>
    <td style="width: 10%;">
        <a href="<?php echo url('vendor/report/show'); ?>" class="btn dark btn-sm" title="View  payments"><i class="fa fa-eye"></i>
        </a>

    </td>
   
</tr>
@endforeach
@else
<tr>
    <td colspan="9" class="text-center">Data not found!</td>

</tr>
@endif
</tbody>
</table></div>
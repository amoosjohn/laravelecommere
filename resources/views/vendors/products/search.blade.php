<?php
use App\Functions\Functions;
use App\GalleryImage;
?>
<table class="table table-hover" data-toggle="dataTable" data-form="deleteForm">
<tbody>
@if(count($model)>0)
@foreach($model as $row)
<?php
$status = '';
$color = '';
$commission = 0;
if (array_key_exists($row->status, $statuses)) {
    $status = $statuses[$row->status];
}
if (array_key_exists($row->status, $colors)) {
    $color = $colors[$row->status];
}
if(isset($row->categoryCommission)) {
    $price = ($row->sale_price==0)?$row->price:$row->sale_price;
    $commission = Functions::calculateCommission($row->categoryCommission, $price);
    
}
$image = GalleryImage::getMainImage($row->id);
?>
<tr>
    <td style="width:  3%;"><input type="checkbox" class="single" name="delete[]" value="1" data-id="{{ $row->id }}"/></td>
    <td style="width:  5%;">{{ $row->id }}</td>
    <td style="width: 10%;">
        <img src="{{ $image }}" class="img-responsive" style="width:100px;height:100px"/></td>
    <td style="width: 15%;">{{ $row->name }}</td>
    <td style="width: 10%;">
        <?php echo ($row->parentCategoryName!='')?$row->parentCategoryName.' <i class="fa fa-chevron-right"></i> ':''; 
        echo ($row->subCategoryName!='')?$row->subCategoryName.' <i class="fa fa-chevron-right"></i> ':'';?> 
        {{ $row->categoryName }}</td>    
    <td style="width: 8%;">{{ (count($row->brands)>0)?$row->brands->name:'' }}</td>
    <td style="width: 8%;">{{ ($row->sale_price==0)?$symbol.".".Functions::moneyFormat($row->price):$symbol.".".Functions::moneyFormat($row->sale_price) }}</td>
    <td style="width: 5%;">{{ $symbol.".".$commission }}</td>
    <td style="width: 5%;"><span class="{{ $color }} sbold">{{ $status }}</span></td>
    <td style="width: 8%;">
        <a href="<?php echo url('product',$row->link); ?>" class="btn dark btn-sm" title="View product details on site" target="_blank"><i class="fa fa-globe"></i>
        </a>
        @if(Auth::user()->role_id==3 || $permissionEdit>0)
        <a href="<?php echo url('vendor/products/' . $row->id . '/edit'); ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i>
        </a>
        @endif
        @if(Auth::user()->role_id==3 || $permissionDel>0)
        {!! Form::open(array('url' => 'vendor/products/' .$row->id,'class'=>'form-inline form-delete','id'=>'delete')) !!}
        {!! Form::hidden('_method', 'DELETE') !!}
        <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete" title="Delete"><i class="fa fa-trash"></i> </button>
        {!! Form::close() !!}
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
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure to delete this product?</p>
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
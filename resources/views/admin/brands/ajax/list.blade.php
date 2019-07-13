<table class="table table-hover">
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
        <td style="width: 10%;">
            <img src="{{ ($row->image!='')?asset('/'.$row->image):url('front/images/no-image.jpg') }}" class="img-responsive" style="width:100px;height:100px"/>
        </td>
        <td style="width: 10%;">{{ $row->name }}</td>
        <td style="width: 10%;"><?php echo ($row->top == 1) ? '<i class="fa fa-check-square"></i> Top<br/>' : '' ?>
            <?php echo ($row->fashion == 1) ? '<i class="fa fa-check-square"></i> Fashion<br/>' : '' ?>
            <?php echo ($row->electronic == 1) ? '<i class="fa fa-check-square"></i> Electronic<br/>' : '' ?></td>
        <td style="width: 10%;">{{ (count($row->users)>0)?$row->users->firstName:'' }}</td>
        <td style="width: 10%;" class="{{ $color }} sbold"><i class="fa fa-circle"></i> {{ $status }}</td>
        <td style="width: 10%;">
            <a href="{{ url('brand/' . $row->key) }}" class="btn dark btn-sm" title="View this brand product on site" target="_blank"><i class="fa fa-globe"></i></a>
            <a href="<?php echo url('admin/brands/edit/' . $row->id); ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
            </a>
            <a data-href="<?php echo url('admin/brands/delete/' . $row->id); ?>" data-target="#confirm-delete" class="btn btn-danger btn-sm delete"  data-toggle="modal" title="Delete"><i class="fa fa-trash"></i> </a>
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


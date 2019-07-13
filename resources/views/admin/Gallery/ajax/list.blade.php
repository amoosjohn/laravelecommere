<?php
$currencies = Config::get('params.currencies');
$currency = $currencies[Config::get('params.currency_default')]['symbol'];
?>
<div class="box-header with-border">
    <h3 class="box-title">( Total Galleries : {{ count($model) }} )</h3>
    <div class="box-tools">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button> 
    </div>
</div>
<div class="box-body">
    <?php if (count($model) > 0) { ?>

        <ul class="products-list product-list-in-box">
            <table class="table" id="order_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($model as $row)
                    <tr>
                        <td><a href=""><?php echo $i; ?></a></td>
                        <td><a href="{{ url('admin/gallery/show',$row->id )}}"><?php echo $row->title; ?></a></td>
                        
                        <td><?php echo date('d/m/Y', strtotime($row->created_at)); ?></td>
                      
                        <td>
                            <a href="{{ url('admin/gallery/edit/'.$row->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="{{ url('admin/gallery/delete/'.$row->id) }}" class="btn btn-danger delete"><i class="fa fa-trash"></i> </a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                    @include('admin/commons/delete_modal')
                </tbody>

            </table>
            <?php //echo $model->appends(Input::query())->render(); 
            
            ?>
        </ul>


    <?php } else {
        ?>
        <div class="">
            No Data found. . .
        </div>
    </div>
<?php }
?>


<script>
    jQuery('.delete').click(function ()
    {
        $('#closemodal').attr('href', $(this).data('link'));
    });
</script>



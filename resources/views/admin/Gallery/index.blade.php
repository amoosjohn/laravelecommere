@extends('admin/admin_template')
@section('content')
<div class="row">
    <div class="col-xs-12">
        @include('admin/commons/errors')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Search</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>   
                </div>
            </div>

            <form class="form" role="form" id="filter">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('Title') !!}
                                {!! Form::text('title',(isset($title))?$title:'', array('class' => 'form-control', 'id' => 'title') ) !!}
                            </div>
                        </div>

                        <div class='clearfix'></div>
                        <input type="hidden" class="form-control" name="page" id="page" value="<?php echo $page; ?>"/>
                         
                        <div class='clearfix'></div>

                        <div class=" form-group col-sm-6 col-sm-offset-3">
                            <a href="{{ url('admin/galleries') }}" class="btn btn-danger btn-block btn-flat">Clear Search</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <!-- Left col -->
    <div class="col-md-12">

        <div class="box box-primary" id="listing">

        </div>
        <?php echo $galleries->render();?>

    </div>
</div>

<script>
    jQuery('.delete').click(function ()
    {
        $('#closemodal').attr('href', $(this).data('link'));
    });
</script>
<script>
    $(document).ready(function () {
        galleryListing();
    });
    $("form").submit(function (e) {
        galleryListing();
        e.preventDefault();

    });
    $("form").change(function (e) {
        galleryListing();
        e.preventDefault();
    });
    $("#title").keyup(function (e) {
        galleryListing();
    });

    function galleryListing() {
        var formdata = $("#filter").serialize();
        $.ajax({
            url: "<?php echo url('admin/gallery/listing'); ?>",
            type: 'get',
            dataType: 'html',
            data: formdata,
            success: function (response) {
                $('#listing').html(response);
            },
            error: function (xhr, status, response) {
            }
        });
    }
</script>
@endsection
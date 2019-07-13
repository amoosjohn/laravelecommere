@extends('admin/admin_template')
@section('content')

<?php 
    //print_r($gallery_info); 
?>
<div class="panel panel-default">
    <div class="panel-heading">
        View Gallery Detail
    </div>
    <div class="panel-body">
        <table class="cust-table">
            <tr>
                <th width="%">Title</th><td>:</td><td width="90%">{{$gallery_info->title}}</td>
            </tr>
             <tr>
                <th width="">Description</th><td>:</td><td width="90%">{{$gallery_info->description}}</td>
            </tr>

            <tr>
                <th>Image</th><td>:</td><td width="90%"><img src="<?php echo asset('uploads/consultants/images/'. $gallery_info->image); ?>"/></td>
            </tr>

            <tr>
                <th>Created at</th><td>:</td><td width="90%">{{$gallery_info->created_at}}</td>
            </tr>
            <tr>
                <th>Updated at</th><td>:</td><td width="90%">{{$gallery_info->updated_at}}</td>
            </tr>

            <tr>
                <td colspan="3"><a href="{{ url('admin/galleries') }}" class="btn btn-primary">Back</a></td>
            </tr>

        </table>
    </div>
</div>
@endsection

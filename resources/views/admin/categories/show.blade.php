@extends('admin/admin_template')
@section('content')

<?php 
    //print_r($gallery_info); 
?>
<div class="panel panel-default">
    <div class="panel-heading">
        View Category Detail
    </div>
    <div class="panel-body">
        <table class="cust-table">
         
        @foreach($category_info as $item)
            <tr>
                <th width="%">Title</th><td>:</td><td width="90%">{{$item->name}}</td>
            </tr>
             <tr>
                <th width="">Description</th><td>:</td><td width="90%"><?php echo $item->description ;?></td>
            </tr>
             <tr>
                <th width="">Commission</th><td>:</td><td width="90%">{{$item->commission}}%</td>
            </tr>

            <tr>
                <th>Image</th><td>:</td><td width="90%"><img src="<?php echo asset('uploads/categories/images/'. $item->image); ?>" style="width: 150px; height: 150px;"/></td>
            </tr>
            
             <tr>
                <th>Thumbnail</th><td>:</td><td width="90%"><img src="<?php echo asset('uploads/categories/thumbnail/'. $item->thumbnail); ?>" style="width: 100px; height: 100px; margin: 10px 0;"/></td>
            </tr>

            <tr>
                <th>Created at</th><td>:</td><td width="90%">{{$item->created_at}}</td>
            </tr>
            <tr>
                <th>Updated at</th><td>:</td><td width="90%">{{$item->updated_at}}</td>
            </tr>

        @endforeach

            <tr>
                <td colspan="3"><a href="{{ url('admin/categories') }}" class="btn btn-primary">Back</a></td>
            </tr>

        </table>
    </div>
</div>
@endsection

@extends('admin/admin_template')

@section('content')
<style>
    img {
        height: 260px;
        width: 100%;
    }
</style>

<div class="row">
    <div class="col-md-12">
        @include('admin/commons/errors')
        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">Admin User's Information </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>

                </div>
            </div>

            <?php
            $user = $data[0];
            ?>        
            @if($user->status == '1')
            <div class="box-body bg-success">
                @else
                <div class="box-body bg-danger">
                    @endif

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="col-sm-12">
                                @if($data[0]->image == '')
                                <img  src="{{ url('front/images/usr.jpg')}}" alt="User Avatar">
                                @else
                                <img src="{{ url('uploads/users/'.$data[0]->image) }}" alt="User Avatar">
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-9">

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>First Name :</td>
                                        <td>{{ $data[0]->firstName }}</td>
                                    </tr>
                                    <tr>
                                        <td>Last Name :</td>
                                        <td>{{ $data[0]->lastName }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email :</td>
                                        <td>{{ $data[0]->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>About :</td>
                                        <td>{{ $data[0]->about }}</td>
                                    </tr>
                                    <tr>
                                        <td>JoinFrom :</td>
                                        <td>{{ $data[0]->joinFrom }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tagline :</td>
                                        <td>{{ $data[0]->tagline }}</td>
                                    </tr>
                                    <tr>
                                        <td>Location :</td>
                                        <td>{{ $data[0]->location }}</td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>

                    </div>

                    @include('admin/commons/users_action')
                </div>

            </div>
        </div>

        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">( Total Tasks : {{ count($model) }} ) </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>

                    </div>
                </div>

                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        <table class="table" id="order_table">
                            <thead>
                                <tr >
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <td></td> 

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($model as $row)
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->description }}</td>
                                    <td>{{ $row->taskStatus }}</td>
                                    <td><?php echo date("d M Y", strtotime($row->dueDate)); ?></td>
                                    <td><a href="{{ url('admin/task/edit/'.$row->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        <button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#myModal" data-link="<?php echo url('admin/task/delete/' . $row->id); ?>"><i class="fa fa-trash"></i> </button></td>
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                                @include('admin/commons/delete_modal')

                            </tbody>

                        </table>
                        <?php echo $model->render(); ?>

                    </ul>
                </div>

            </div>
        </div>
    </div>
    <script>
        jQuery('.delete').click(function ()
        {
            $('#closemodal').attr('href', $(this).data('link'));
        });
    </script>
    @endsection

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
                <h3 class="box-title">User's Information </h3>
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
<!--                        <div class="col-sm-3">
                            <div class="col-sm-12">
                                @if($data[0]->image == '')
                                <img  src="{{ url('front/images/usr.jpg')}}" alt="User Avatar">
                                @else
                                <img src="{{ url('uploads/users/profile/'.$data[0]->image) }}" alt="User Avatar">
                                @endif
                            </div>
                        </div>-->
                        <div class="col-sm-12">

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
                                </tbody>
                            </table>

                        </div>

                    </div>
                    <br>
                    <div class="col-sm-12">
                        <a href="{{ url('admin/users') }}" class="btn btn-default">Back</a>
                    </div>
                    
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

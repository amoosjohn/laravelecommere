@extends('layout')
<?php
$title = 'Oops!';
$description = '';
$keywords = '';
?>
@include('front/common/meta')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <h1>
                    Oops!</h1>
                <h2>
                    <i class="fa fa-exclamation-triangle" style="color:red"></i> 404 Not Found</h2>
                <h3>Sorry, an error has occured, Requested page not found!</h3>
            </div>
        </div>
    </div>
</div>
@endsection
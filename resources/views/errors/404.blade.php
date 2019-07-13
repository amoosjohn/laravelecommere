@extends('layout')

@section('content')
<style>
    .alert-info {
    background-color: transparent;
}
</style>
<section class="prod-area">
<div class="container">

<div class="prod__gird col-sm-12">

    <div class="sort-area bg-white col-sm-12  text-center">
       
    <div class="clearfix"></div>    
    <h3 class="title">
        404 Page Not found
    </h3>
   <p>Oops! We could not find the page you requested!</p>

    <div class="price__buy">
        <button type="button" onclick="window.location = '{{url('/')}}'" class="btn btn-primary btn-sm">
        Go back to homepage</button>
    </div>
    </div>		
    
</div>
</div>
</section>
@include('front.common.cartjs')
@endsection

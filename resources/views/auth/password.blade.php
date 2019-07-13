@extends('vendors/vendor_login_template')
@section('content')
<!-- BEGIN LOGIN -->
<div class="content">
<div class="logo">  
    <a href="{{ url('/') }}">
        <img src="{{ asset('front/images/small.png') }}"  alt="" width="100px" heigh="100px"/> </a>
</div>
    <div class="flash-message">
        @include('vendors.commons.errors')
    </div> <!-- end .flash-message -->
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" method="POST" action="{{ url('/password/email') }}">
        {{ csrf_field() }}
        <h3 class="form-title">Forgot Password</h3>
        <p>Enter your email below and we will send you instructions on how to reset your password</p>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="email" value="{{ old('email') }}"  autocomplete="off" placeholder="Your Email" name="email" value="{{ old('email') }}" required/> </div>
        </div>
       
        <div class="form-actions">
            <button type="submit" class="btn green pull-right"> Submit </button>
        </div>
        <div class="forget-password">
            <h4>Login into your account?</h4>
            <p> Click<a href="{{url('vendor/login')}}"> here </a> to login. </p>
        </div>
    </form>
</div> 
@endsection

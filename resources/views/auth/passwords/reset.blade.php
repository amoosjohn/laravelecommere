@extends('vendors/vendor_login_template')

@section('content')
<div class="content">
<div class="logo">  
    <a href="{{ url('/') }}">
        <img src="{{ asset('front/images/small.png') }}"  alt="" width="100px" heigh="100px"/> </a>
</div>
    <div class="flash-message">
        @include('vendors.commons.errors')
    </div> <!-- end .flash-message -->
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" method="POST" action="{{ url('/password/reset') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <h3 class="form-title">Reset Password</h3>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="email" value="{{ old('email') }}"  autocomplete="off" placeholder="Your Email" name="email" value="{{ old('email') }}" required/> </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Your Password" name="password" required/> </div>

        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Confirm Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Confirm Password" name="password_confirmation" required/> </div>

        </div>
       
        <div class="form-actions">
            <button type="submit" class="btn green pull-right"> Reset Password </button>
        </div>
        <div class="forget-password">
            <h4>Login into your account?</h4>
            <p> Click<a href="{{url('vendor/login')}}"> here </a> to login. </p>
        </div>
    </form>
</div>
@endsection

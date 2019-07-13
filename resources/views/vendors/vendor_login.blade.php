
@extends('vendors/vendor_login_template')

@section('content')

<!-- BEGIN LOGIN -->
<div class="content">
<div class="logo">
    <a href="{{ url('/') }}">
        <img src="{{ asset('front/images/small.png') }}"  alt="" width="100px" heigh="100px"/> </a>
</div>
    <div class="flash-message">
        @if (count($errors) > 0)
        <!-- Form Error List -->
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div> <!-- end .flash-message -->
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" method="POST" action="{{ url('postLogin') }}">
        {{ csrf_field() }}
        <h3 class="form-title">Login to your account</h3>
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
        <div class="form-actions">
            <label class="rememberme mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" value="1" /> Remember me
                <span></span>
            </label>
            <button type="submit" class="btn green pull-right"> Login </button>
        </div>
        <div class="forget-password">
            <h4>Forgot your password ?</h4>
            <p> Click<a href="{{url('vendor/forgot')}}"> here </a> to reset your password. </p>
        </div>
    </form>
</div> 
@endsection

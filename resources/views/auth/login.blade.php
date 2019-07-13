@extends('layout')

@section('content')
<?php

use App\Functions\Functions;
?>
<section class="login-area pt60 pb60">
    <div class="container">
        <div class="row">
            <div class="login-offset login-box col-md-5 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Login to your Account</div>

                    <div class="panel-body pl10 pr10">
                        <form class="form" method="POST" action="{{ url('postLogin') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-12 control-label"><i class="fa fa-envelope"></i>Email Address</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email"/>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-12 control-label"><i class="fa fa-lock"></i>Password</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-inline fom checker-area0">
                                        <label for="headbar__labelColour">
                                            <span class="fnc__checkbox checker-area">
                                                <input type="checkbox" id="headbar__labelColour" name="remember" {{ old('remember') ? 'checked' : '' }} class="form-control">
                                            </span>         
                                        Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 forgot-link--div pr0 text-right">
                                    <a class="btn btn-link forgot-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <!-- <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-inline fom checker-area0">
                                        <label class="fnc__checkbox checker-area">
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="form-control"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div> -->

                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary login-btn">
                                        Login
                                    </button>

                                    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            
                        </form>
                    </div>
                    <div class="form__footer form-group">
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <div class="hed crossline">
                                <h2 class="">New to Vitalmart?</h2>
                                <hr>
                            </div>
                            <a class="btn btn-link form__footerBtn" href="signup">
                                Sign up
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

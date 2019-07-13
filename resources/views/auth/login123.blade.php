@extends('layout')

@section('content')
  <div class="login-logo">
    <a href="#"><b><?php echo Config('param.site_name');?></b></a>
  </div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session</p>
		
				@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> Problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
				@endif
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
						{{ csrf_field() }}
						
						
						<div class="form-group has-feedback">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
						</div>
						
						<div class="form-group has-feedback">
							<input type="password" class="form-control" name="password" placeholder="Password" required>
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						</div>
						
						
						<div class="row">
							<div class="col-xs-8">
								<div class="checkbox icheck">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
							<!-- /.col -->
							<div class="col-xs-4">
							  <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
							</div>
							<!-- /.col -->
						</div>


						<div class="form-group">
							<div class="col-md-8 col-md-offset-6">

								<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
							</div>
						</div>
					</form>
	</div>
		
@endsection

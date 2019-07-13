@extends('signup_login')

@section('content')

	
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>New User Signup!</h2>
						
						@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
						@endif
						
						<form method="POST" action="{{ url('/auth/register') }}">
							
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="text" placeholder="Name" name="name" value="{{ old('name') }}" />
							<input type="email" placeholder="Email Address" name="email" value="{{ old('email') }}" />
							<input type="password" placeholder="Password" name="password" />
							<input type="password" placeholder="Confirm Password" name="password_confirmation" />
							
							<span>
								<input type="checkbox" id="premium" class="checkbox"> 
								Premium Registration
							</span>
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Login to your account</h2>
						
						<form>
							
							<input type="text" placeholder="Name" />
							<input type="email" placeholder="Email Address" />
							
							
							<button type="submit" class="btn btn-default">Login</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->


@endsection


@extends('layouts.login')

@section('content')
<!-- <section class="main-body" id="my-opportunities-page"> -->
<section class="main-body" id="login-page">

<div class="login-wrapper">
	<div class="left-wrapper">
		<img src="images/login-image.png" class="img-responsive">
	</div>

	<div class="right-wrapper">
		<div class="logo">
			<a class="navbar-brand" href="/"><img src="{{ URL::asset('images/Logo.svg') }}"></a>
		</div>
		<div class="welcome-back">
		<!--	Welcome Back -->
		</div> 
		@php $selectedTab = (old('tab_id')!=null ? old('tab_id') : 'signin') @endphp
		<div class="login-forms-wrapper">
			<div class="">

				<!-- Login-Links -->


				<div class="login-links">
					<ul class="nav">
						<li class="active">
							<a class="signin {{ ($selectedTab=='signin') ? 'active' : '' }}" data-toggle="tab" href="#signin">Sign In</a>
						</li>
						<li>
							<a class="signup {{ ($selectedTab=='signup') ? 'active' : '' }}" data-toggle="tab" href="#signup">Sign Up</a>
						</li>
						<!--<li>
							<a class="forgot" data-toggle="tab" href="#forgot">Forgot</a>
						</li>-->
					</ul>
				</div>



				<!-- Tab panes -->

				<div class="tab-content">
					<div id="signin" class="tab-pane {{ ($selectedTab=='signin') ? 'active' : 'fade' }}">
						
							<form method="POST" class="row clearfix login-form" action="{{ route('login') }}">
	@csrf
							<div class="col-md-12">
								<div class="form-group clearfix">
										<input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ ($selectedTab=='signin') ? old('email') : '' }}" required autocomplete="email" autofocus>
									@error('email')
										@if($selectedTab=='signin')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@endif
									@enderror
									
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"  name="password" required autocomplete="current-password">

									@error('password')
										@if($selectedTab=='signin')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@endif
									@enderror
				<input id="tab_id" type="hidden" name="tab_id" value="signin">
			<button type="submit" class="login-btn">
			{{ __('Sign In') }}
			</button>

			<?php /*<a class="reset_pass" href="{{route('password.reset')}}">Forgot password?</a> */ ?>
									
								</div>
							</div>
						</form>
					</div>

<div id="signup" class="tab-pane {{ ($selectedTab=='signup') ? 'active' : 'fade' }}">

		<form method="POST" class="row clearfix login-form" action="{{ route('register') }}">
			@csrf
		<div class="col-md-12">
			<div class="form-group clearfix">
					<input id="name" type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

				@error('name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
<!-- 								<input id="lastName" type="text" placeholder="LastName" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required autocomplete="lastName" autofocus>

				@error('lastName')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror -->
				
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ ($selectedTab=='signup') ? old('email') : '' }}" required autocomplete="email">

				@error('email')
					@if($selectedTab=='signup')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@endif
				@enderror
				
					<input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
				
					<input id="password-confirm"  placeholder="Confirm Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">

					<div class="form-group row">
					<div class="select-role">
					<div class="form-check form-check-inline">
					<p class="styled-label">{{ __('Register as:') }}</p>
					</div>
					<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="role" value="2" checked>
					<label class="form-check-label">{{ __('Manager') }}</label>
					</div>
					<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="role" value="3" >
					<label class="form-check-label"> {{ __('Expert') }} </label>
						</div>
					</div>

					<input id="tab_id" type="hidden" name="tab_id" value="signup">
				<button type="submit" class="login-btn register-btn">
{{ __('Register') }}
</button>
				
			</div>
		</div>
	</form>
</div>

</div>

			</div>
		</div>
	</div>
</div>

</section>
<script type="text/javascript">
	
	$(document).ready(function() {
		
		$(document.body).on("click", "a[data-toggle='tab']", function(event) {
			location.hash = this.getAttribute("href");
		});
	});
	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash; 
	$('.login-links ul li a[href="' + hash + '"]').tab('show');
</script>
@endsection

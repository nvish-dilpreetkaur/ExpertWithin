<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid paddn">
		<div class="header-wrap inner-header-wrap">
			<div class="left-header-menu">
				<div class="menu-icon-outer">

					<!-- <ul class="navbar-nav d-flex justify-content-end" id="sidebarCollapse"> -->
					<ul class="navbar-nav d-flex justify-content-end">
						<li class="nav-item">
							<a class="nav-link menuIcon" href="javascript:void(0)" id="sidebarCollapse">
								<div id="nav-icon" class="">
									<span></span>
									<span></span>
									<span></span>
									<span></span>
								</div>
								<div class="menu-title">Menu</div>
							</a>

						</li>

					</ul>

				</div>


			</div>
			<div class="right-side">
				<div class="search-icon-hdr">
					

				</div>
				<div class="search-container inner-search-container">
					
				</div>
				<a class="site-logo-top" href="{{ url('/') }}">
					<img src="{{ URL::asset('images/Logo.svg') }}">
				</a>
				<div class="right-header-login">
					@auth
					 <!-- Welcome <strong>{{Auth::user()->firstName}} {{Auth::user()->lastName}}</strong>-->
					 <!-- <a href="#" data-toggle="modal"><i class="fas fa-users"></i></i>{{ __('Community') }}</a> -->
					 <a href="#" data-toggle="modal"><i class="fas fa-users"></i><span class="community-txt">{{ __('Community') }}</span></a>
					 @endauth
					@guest
						 @if (Route::has('register')) 
							 <a href="{{ route('login') }}#signup">{{ __('Register') }}</a> / 
						 @endif
						 <a href="{{ route('login') }}">{{ __('Login') }}</a>
					@endguest 
					

				</div>
			</div>
		</div>
	</div>
</nav>
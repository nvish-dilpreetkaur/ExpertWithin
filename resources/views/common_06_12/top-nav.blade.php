	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid paddn">
			<div class="header-wrap">
				<div class="left-header-menu">
					<div class="menu-icon-outer menu-icon-home-page">

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
						<a class="nav-link" href="javascript:void(0)" id="nav-link-search">
							<!-- <i class="fa fa-search"></i> -->
							<img src="{{ URL::asset('images/Magnify.svg') }}" class="magnify-pic">
						</a>

					</div>
					
					<form method="POST" action="{{ route('search') }}">
					<div class="search-container">
						{{ csrf_field() }}
						<!-- <div class="search-input"><input type="text" name="q" placeholder="Search for job Title, skills" value="{{ isset($searchedItem) ? $searchedItem : ''}}"></div> -->
						<div class="search-input">	<img src="http://kloves.nvish.com/images/Magnify.svg" class="magnify-pic lens-pic-resp"><input type="text" name="q" id="q" placeholder="Search for job Title, skills" value="{{ isset($searchedItem) ? $searchedItem : ''}}"></div>
					
						<div class="show-filters"><a href="#cntnt-top-front">Show Filters</a></div>

						<div class="nav-link-close">
							@if (Request::path() == 'search')
								<a href="{{ url('/') }}"><i class="fa fa-times-thin fa-2x" aria-hidden="true"></i></a>
							@else
								<a href="javascript:void(0)"><i class="fa fa-times-thin fa-2x" aria-hidden="true"></i></a>
							@endif
						</div>
					</div>
					</form>
					<a class="site-logo-top" href="{{ url('/') }}">
						<img src="{{ URL::asset('images/Logo.svg') }}">
					</a>
					<div class="right-header-login">
						@auth
						 <!-- Welcome <strong>{{Auth::user()->firstName}} {{Auth::user()->lastName}}</strong>-->
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

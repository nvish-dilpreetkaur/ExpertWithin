<!-- Sidebar  -->
<nav id="sidebar">
	<div id="dismiss">
		<!-- <i class="fas fa-arrow-left"></i> -->
		<div class="close-txt"><i class="fa fa-times-thin fa-2x" aria-hidden="true"></i></div>
	</div>

	<div class="sidebar-header">
    <i class="fas fa-user-circle"></i>
    <div class="logged-user-name"><span>{{ Auth::user()->firstName }}</span></div>
  </div>
 
	<ul class="list-unstyled components">
    @auth
    <li class="for-menu-brdr-btm"><a href="{{ route('profile') }}">My Profile</a></li>
    <li><a href="{{ route('my-opportunities') }}">My Opportunities</a></li>
    <li><a href="{{ route('activities') }}">My Activities</a></li>
    @if( in_array(config('kloves.ROLE_MANAGER'),explode(",",Auth::user()->roles)) || in_array(config('kloves.ROLE_ADMIN'),explode(",",Auth::user()->roles)) )
        <li><a href="{{ route('create-opportunity') }}">Create Opportunity</a></li>
        <!--li><a href="{{ route('dashboard') }}">My Dashboard</a></li-->
        <li class="for-menu-brdr-btm"><a href="{{ route('opportunities') }}">Open Opportunities</a></li>
		@endif
    
    @if( in_array(config('kloves.ROLE_ADMIN'),explode(",",Auth::user()->roles)) )
   <!-- <li class=""><a href="{{ route('managers') }}">All Managers</a></li>-->
    <li class=""><a href="{{ route('users') }}">User Management</a></li>
    <li class="for-menu-brdr-btm"><a href="{{ route('taxonomy-list') }}">Administration</a></li>
		@endif
		
		<li> <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="fas fa-power-off"></i> {{ __('Logout') }}
            </a>
			 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
		</li>
		@endauth
	</ul>
</nav>

<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for opportunities...">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button">
            <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

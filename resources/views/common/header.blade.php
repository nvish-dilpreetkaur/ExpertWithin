@php $current_user_detail = get_user_profile_details(); @endphp
<!-- header :start-->
<div class="container-fluid for-container-fluid">
    <div class="container header-bg">
      <div class="header-wrap">
      <div class="row clearfix">
        <div class="col-md-2">
          <div class="main-logo">
            <a href="/"><i class="fas fa-door-open"></i><img src="{{ URL::asset('images/Logo.svg') }}"></a>
          </div>
        </div>
        <div class="col-md-4 for-null-paddng-left">
          <div class="header-search-box">
            <i class="fas fa-search"></i>
          </div>				 
        </div>
        <div class="col-md-6">
          <div class="header-rite-icons">
            	<ul>
                  <li><a href="#"><i class="fas fa-door-open"></i><p>Opportunities</p></a></li>
                  <li><a href="#"><i class="fas fa-user-friends"></i><p>My Team</p></a></li>
                  <li><a href="#"><i class="fas fa-heart"></i><p>Favorites</p></a></li>
                  <li><a href="#"><i class="fas fa-bell"></i><p>Notifications</p></a></li>
                  <!-- <li id="header-profile__dropdown-view" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> -->
                  <li class="dropdown-for__user-infor-card">
                   @if(!empty($current_user_detail->image_name))
						<a href="#" class="main-header--user-info-card__picture cur_image user-pic__for-profile--header" style="background-image: url('{{$current_user_detail->image_name}}') !important;"><i class='fas fa-user-circle' id="def_pic"></i><p>Me</p></a>
				   @else
						<a href="#" id="header_def_image" class="main-header--user-info-card__picture cur_image"><i class="fas fa-user-circle for-header-user__default-pic" id="header_def_pic" aria-hidden="true"></i><p>Me</p></a>
				   @endif
                  </li>
                  <!-----modal-content-->
                  <!-- <div class="dropdown-menu header-profile-dropdown-modal" aria-labelledby="header-profile__dropdown-view"> -->
                  <div class="dropdown-menu header-profile-dropdown-modal dropdown-for__user-infor-card--view">
                      <div class="header-dropdown__profile--user-info">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-12">
                          <div class="header-dropdown__profile--user-profl"><a href="{{route('profile')}}">My profile</a></div>
                            <!-- @if(!empty($current_user_detail->image_name)) -->
								<!-- <div class="main-page__dropdown--user-info-card__picture cur_image" style="background-image: url('{{$current_user_detail->image_name}}') !important;">
								  <i class=''></i>
								</div> -->
							@else
									<!-- <div class="main-page__user-info-card__picture cur_image"><i class="fas fa-user-circle fa-2x def_pic"  id="def_pic" aria-hidden="true"></i></div> --->
							@endif	
                          </div>
                          <div class="col-md-0 for-null-paddng">
                            <div class="">
                            <!-- <div class="header-dropdown__profile--user-name">{{ Auth::user()->firstName }}</div>-->
                              <!-- <div class="header-dropdown__profile--user-profl"><a href="{{route('profile')}}">My profile</a></div> -->
                            </div>
                          </div>
                        </div><!----row-ends-->
                      </div>

                      <div class="main-page__user-info-card__expert-tokens">
                            <div class="expert-tokens__stats--title-section">
                                <div class="expert-tokens__stats--title">
                                  <i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span> Expert Tokens</span>
                                </div>
                                <div class="expert-tokens__stats--sub-title">
                                  <p>Use your tokens</p>
                                </div>
                            </div>
            
                            <div class="expert-tokens__stats--numbers-section">
                                <div class="expert-tokens__stats--numbers">
                                    <span>33</span>
                                </div>
                                <div class="expert-tokens__stats--numbers">
                                  <p class="sub-title">Total tokens</p>
                                </div>
                            </div>	
                        </div>



                        <div class="header-dropdown__profile--user-stats-area">
                            <div class="header-dropdown__profile-card__stats--title">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                                <span> Who’s viewed...</span>
                            </div>
          
                            <div class="header-dropdown__profile-card__stats--number">
                                <a href="#">13</a>
                            </div>
                            <!----->
                            <div class="header-dropdown__profile-card__stats--title">
                                <i class="fas fa-user-friends" aria-hidden="true"></i>
                                <span>My Team</span>
                            </div>
          
                            <div class="header-dropdown__profile-card__stats--number">
                                <span><a href="#">6</a></span>
                            </div>
                            <!------>
                            <div class="header-dropdown__profile-card__stats--title">
                                <i class="fas fa-user-plus" aria-hidden="true"></i>
                                <span> Following</span>
                            </div>
          
                            <div class="header-dropdown__profile-card__stats--number">
                                <span><a href="#">8</a></span>
                            </div>
                            <!------>
                        </div><!---USER_STATS-END-->

                          <div class="header-dropdown__profile--user-bottom-list">
                              <ul>
                                  <li><i class="fas fa-briefcase for-element-with--fire-brick-color" aria-hidden="true"></i><a href="#">My opportunities for candidates</a></li>
                                  <li><i class="fas fa-briefcase for-element-with--fire-brick-color" aria-hidden="true"></i><a href="#">My applied opportunities</a></li>
                                  @if( in_array(config('kloves.ROLE_ADMIN'),Auth::user()->roles) )
                                    <li><i class="fas fa-user-friends for-element-with--fire-brick-color" aria-hidden="true"></i><a href="{{ route('users') }}">User Management</a></li>
                                    <li><i class="fas fa-briefcase for-element-with--fire-brick-color" aria-hidden="true"></i><a href="{{ route('taxonomy-list') }}">Administration</a></li>
                                  @endif
                              </ul>
                          </div>
                            
                              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><div class="header-profile-dropdown__logout">Logout</div></a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                              </form>
                          
                      </div>
                      </div>
                </ul>
          
          </div>
        </div>
      </div>
      </div>
    </div>
</div>

@php $current_user_detail = get_user_profile_details(); @endphp
<!-- header :start-->
<div class="container-fluid for-container-fluid">
    <div class="container header-bg">
      <div class="header-wrap">
      <div class="row clearfix">
        <div class="col-md-2">
          <div class="main-logo">
            <a href="/"><img src="{{ URL::asset('images/Logo.svg') }}"></a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="header-search-box">
            <i class="fas fa-search"></i> Search...
          </div>				 
        </div>
        <div class="col-md-6">
          <div class="header-rite-icons">
            	<ul>
                  <li><a href="#"><i class="fas fa-briefcase"></i><p>Opportunities</p></a></li>
                  <li><a href="#"><i class="fas fa-user-friends"></i><p>My Team</p></a></li>
                  <li><a href="#"><i class="fas fa-heart"></i><p>Favorites</p></a></li>
                  <li><a href="#"><i class="fas fa-bell"></i><p>Notifications</p></a></li>
                  <li id="header-profile__dropdown-view" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   @if(!empty($current_user_detail->image_name))
						<a href="#" class="main-header--user-info-card__picture cur_image" style="background-image: url('{{$current_user_detail->image_name}}') !important;"><i class='' id="def_pic"></i><p>Me</p></a></li>
				   @else
						<a href="#" class="main-header--user-info-card__picture cur_image"><i class="fas fa-user-circle for-header-user__default-pic def_pic" id="def_pic" aria-hidden="true"></i><p>Me</p></a></li>
				   @endif
                  </li>
                  <!-----modal-content-->
                  <div class="dropdown-menu header-profile-dropdown-modal" aria-labelledby="header-profile__dropdown-view">
                      <div class="header-dropdown__profile--user-info">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-4 for-null-paddng">
                            @if(!empty($current_user_detail->image_name))
								<div class="main-page__dropdown--user-info-card__picture cur_image " style="background-image: url('{{$current_user_detail->image_name}}') !important;">
								  <i class=''></i>
								</div>
							@else
									<div class="main-page__user-info-card__picture cur_image"><i class="fas fa-user-circle fa-2x def_pic" aria-hidden="true"></i></div>
							@endif	
                          </div>
                          <div class="col-md-8 for-null-paddng">
                            <div class="">
                              <div class="header-dropdown__profile--user-name">{{ Auth::user()->firstName }}</div>								
                              <div class="header-dropdown__profile--user-profl"><a href="{{route('profile')}}">View profile</a></div>
                            </div>
                          </div>
                        </div><!----row-ends-->
                      </div>
                        <div class="header-dropdown__profile--user-stats-area">
                            <div class="header-dropdown__profile-card__stats--title">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                                <span> Who’s viewed your profile</span>
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
                          <div class="header-profile-dropdown__logout">
                              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                              </form>
                          </div>
                      </div>
                      </div>
                </ul>
          
          </div>
        </div>
      </div>
      </div>
    </div>
</div>

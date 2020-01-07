
@extends('layouts.app')
@section('content')   
<div class="container">
	<div class="row clearfix">
	   <div class="main-contnt-body">

       <div class="row clearfix"> 
       <div class="notifications__wrapper">  
                <div class="notifications__wrapper--left-section">
                     <div class="notifications__wrapper--left-section-list">
                             <div class="notifications__wrapper--common-heading">
                                 <div class="notifications__wrapper--common-heading__text">Earlier</div>

                                 
                             </div>
							@if($details['notifications'] != null) 
							   <ul>
								  @foreach ($details['notifications'] as $notification_row)
									@if($notification_row['type_of_notification'] == config('kloves.NOTI_SHARED_OPP') )
									@php $createdAt = Carbon\Carbon::parse($notification_row['created_at'])->format('D, F d, Y');  @endphp
										<li>
											<div class="notifications__page-item-heading-common">
												<i class="fas fa-newspaper" aria-hidden="true"></i>Daily Digest – {{ $todatTime = $createdAt }}                                  
											</div>
											<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												<i class="fas fa-ellipsis-h" aria-hidden="true"></i>
											</div>
											<div class="dropdown-menu notification__page-list-dropdown-options">
												<ul>
													<li><a href="#" class="remove_feed_link"><i class="far fa-times-circle"></i>Remove from feed</a></li>
													<li><a href="#"><i class="far fa-times-circle"></i>Report</a></li>
												</ul>
											</div> 
											 <p class="notification-page__heading-subtext"><span class="common-semibold-text">{{ $notification_row['sender']['firstName'] }} </span> has shared an opportunity <span class="common-semibold-text">{{ $notification_row['opportunity']['opportunity'] }} </span> with you.</p>
									   </li>
									@elseif($notification_row['type_of_notification'] == config('kloves.NOTI_SHARED_ACK') )
										<li>
										 <div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												<i class="fas fa-ellipsis-h" aria-hidden="true"></i>
											</div>
											<div class="dropdown-menu notification__page-list-dropdown-options">
												<ul>
													<li><a href="#" class="remove_feed_link"><i class="far fa-times-circle"></i>Remove from feed</a></li>
													<li><a href="#"><i class="far fa-times-circle"></i>Report</a></li>
												</ul>
											</div>
											@if(!empty($notification_row['sender']['profile']["image_name"]))
                                                <div class="notification-page__user-picture" style="background-image: url('{{ $notification_row['sender']['profile']['image_url'] }}');"><i class="" aria-hidden="true"></i></div>
                                            @else
												<div class="notification-page__user-picture"><i class="fas fa-user-circle fa-3x" aria-hidden="true"></i></div>
                                            @endif
											
											<span class="for-element-with-red-colour">Acknowledge</span> <span class="for-fnt-weight">{{ $notification_row['sender']['firstName'] }}</span> has shared 1 new acknowledgement with you.
										</li>
									@elseif($notification_row['type_of_notification'] == config('kloves.NOTI_NEW_ACK_ADDED') )
										<li>
										 <div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												<i class="fas fa-ellipsis-h" aria-hidden="true"></i>
											</div>
											<div class="dropdown-menu notification__page-list-dropdown-options">
												<ul>
													<li><a href="#" class="remove_feed_link"><i class="far fa-times-circle"></i>Remove from feed</a></li>
													<li><a href="#"><i class="far fa-times-circle"></i>Report</a></li>
												</ul>
											</div>
											@if(!empty($notification_row['sender']['profile']["image_name"]))
                                                <div class="notification-page__user-picture" style="background-image: url('{{ $notification_row['sender']['profile']['image_url'] }}');"><i class="" aria-hidden="true"></i></div>
                                            @else
												<div class="notification-page__user-picture"><i class="fas fa-user-circle fa-3x" aria-hidden="true"></i></div>
                                            @endif
											
											<span class="for-fnt-weight">{{ $notification_row['sender']['firstName'] }}</span> acknowledged you.
										</li>
										
									@elseif($notification_row['type_of_notification'] == config('kloves.NOTI_OPOR_INVITES') )
										<li>
										 <div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												<i class="fas fa-ellipsis-h" aria-hidden="true"></i>
											</div>
											<div class="dropdown-menu notification__page-list-dropdown-options">
												<ul>
													<li><a href="#" class="remove_feed_link"><i class="far fa-times-circle"></i>Remove from feed</a></li>
													<li><a href="#"><i class="far fa-times-circle"></i>Report</a></li>
												</ul>
											</div>
											@if(!empty($notification_row['sender']['profile']["image_name"]))
                                                <div class="notification-page__user-picture" style="background-image: url('{{ $notification_row['sender']['profile']['image_url'] }}');"><i class="" aria-hidden="true"></i></div>
                                            @else
												<div class="notification-page__user-picture"><i class="fas fa-user-circle fa-3x" aria-hidden="true"></i></div>
                                            @endif
											
											<span class="for-fnt-weight">{{ $notification_row['sender']['firstName'] }}</span> has invited you to apply on <span class="for-fnt-weight">{{ $notification_row['opportunity']['opportunity'] }}</span> opportunity.
										</li>
									@elseif($notification_row['type_of_notification'] == config('kloves.NOTI_OPOR_COMPLETED') )
										<li>
										 <div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												<i class="fas fa-ellipsis-h" aria-hidden="true"></i>
											</div>
											<div class="dropdown-menu notification__page-list-dropdown-options">
												<ul>
													<li><a href="#" class="remove_feed_link"><i class="far fa-times-circle"></i>Remove from feed</a></li>
													<li><a href="#"><i class="far fa-times-circle"></i>Report</a></li>
												</ul>
											</div>
											@if(!empty($notification_row['sender']['profile']["image_name"]))
                                                <div class="notification-page__user-picture" style="background-image: url('{{ $notification_row['sender']['profile']['image_url'] }}');"><i class="" aria-hidden="true"></i></div>
                                            @else
												<div class="notification-page__user-picture"><i class="fas fa-user-circle fa-3x" aria-hidden="true"></i></div>
                                            @endif
											
											<span class="for-fnt-weight">{{ $notification_row['sender']['firstName'] }}</span> has completed your opportunity.
										</li>
									@endif
								  @endforeach
							   </ul>
						   @else
							<div class="np_notification">No notifications yet.</div>
						   @endif 
                     </div>
                </div>
                <div class="notifications__wrapper--right-section">
                    <div class="notifications__wrapper--common-heading">
                        <div class="notifications__wrapper--common-heading__text">Notifications</div>
                    </div>

                    <div class="notifications-page__right-filter-by">
                        Filter by
                    </div>
				<div> <!----Notifications-Filter-CLOSED---->



        </div>
        </div>

       
        </div>
    </div>
</div>
@endsection

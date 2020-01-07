       <div class="main-page__cmmn-card--heading daily-digest__heading">
              <i class="fas fa-newspaper"></i>
              <span>
                     Daily Digest – {{ $todatTime = Carbon\Carbon::now()->format('H:ia') }}
                     <div>{{ $todatTime = Carbon\Carbon::now()->format('D, F d, Y') }}</div>
              </span>
       </div>
       @if($current_user_detail['notifications']) 
		   <ul>
				  @foreach ($current_user_detail['notifications'] as $notification_row)
						 @include('notifications.notification-template')
				  @endforeach
		   </ul>
		   <div class="main-page__cmmn-card--footer">
				  <p class="show-more" id="show_more_notifications">Show More</p>
		   </div>
       @else
			<div class="no_notification">No notifications yet.</div>
       @endif 

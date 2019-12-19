
       <div class="main-page__cmmn-card--heading"><i class="fas fa-newspaper"></i>
              <span>Daily Digest – {{ $todatTime = Carbon\Carbon::now()->format('D, F d, Y') }}</span>
       </div>
       @if($current_user_detail['notifications'] != null) 
       <ul>
              @foreach ($current_user_detail['notifications'] as $notification_row)
                     @include('notifications.notification-template')
              @endforeach
       </ul>
       <div class="main-page__cmmn-card--footer">
              <p class="show-more">Show More</p>
       </div>
       @else
       @endif 
 
<div class="row clearfix">
            @if (!empty($pvtcommentList))
            @php $commentCounter = 1 @endphp
            @foreach($pvtcommentList as $cKey1 => $cVal1)
              @if ($commentCounter <= 3 )
              <div class="individual-cmmnt-outer">
                          <div class="date-name-outer">
                            <div class="col cmmn-cmnt-date">{{ $cVal1->created_at }}</div>
                            <div class="col cmmn-cmnt-name">{{ $cVal1->sender }}</div>
                          </div>
                            <div class="col cmmn-cmnt-msg">{{ $cVal1->comment_content }}</div>
              </div>
              @else
                  <a class="link-com-p" href="{{ url('comments', Crypt::encrypt($cVal1->id)) }}">View all comments</a>
              @endif
            @php $commentCounter++ @endphp
            @endforeach
            @endif 
</div>
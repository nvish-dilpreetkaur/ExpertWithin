
@if ($commentList != null)
  @foreach($commentList as $cKey1 => $cVal1)
    <div class="row comment-outer-area">
    <!-- <div class="comment-outer-area"> -->
    <div class="user-profile__comment-section">
            <i class="fas fa-user-circle"></i>
         
    <div class="individual-cmmnt-outer">
       <div class="date-name-outer">
          <div class="col cmmn-cmnt-date">{{ $cVal1->created_at }}</div>
          <div class="col cmmn-cmnt-name">{{ $cVal1->sender }}</div>
        </div>
          <div class="col cmmn-cmnt-msg">{{ $cVal1->comment_content }}</div>
    </div>
    </div> 
    
    <!-- <div> -->
 </div>
  @endforeach
@endif
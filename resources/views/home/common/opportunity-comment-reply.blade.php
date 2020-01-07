<!-----TO VIEW COMMENTS START-->
@if($opp_comments)
	   @php $last_id = 0; @endphp
	   @foreach($opp_comments as $replies)
			@php $last_id = $replies['id']; @endphp
			<div class="view_reply  feed__view-comments-wrapper">
				 @if(!empty($replies['user']['profile']['image_name']))
					@if(!empty($replies['user']['profile']['image_url']))
					<div class="comment-cmn__user-pic">
						<div class="favorite-page-cmn-card__user-pic" style="background:url('{{$replies['user']['profile']['image_url']}}')">
						 </div>
					</div>
					@else
					<div class="comment-cmn__user-pic">
						<i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
					</div>
					@endif
				 @else
					<div class="comment-cmn__user-pic">
					   <i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
				   </div>
				 @endif 
				 <div class="card card-body">
					   <div class="feed__view-comments--user-name">
						   {{$replies['user']['firstName']}}
					   </div>
					   {{$replies['comment']}}
				</div>
				<div class="feed-comments__replies">
				  <a class="cmmn__reply-action" data-toggle="collapse" 
				  href="#replyCollapsibleCommentSecondary_{{$ptype}}{{$replies['id']}}" role="button" aria-expanded="false" 
				  aria-controls="replyCollapsibleComment">Reply</a>
			   </div>
			   <div class="collapse replyCollapsibleCommentSecondary" id="replyCollapsibleCommentSecondary_{{$ptype}}{{$replies['id']}}">
				 <div class="card card-body com_rep">
					   <textarea class="form-control frminput" rows="1" cols="10" id="reply_{{$ptype}}{{ $replies['id'] }}" name="reply"></textarea>
						<div class="invalid-feedback" id="reply_{{ $ptype }}{{ $replies['id'] }}-error">Please fill out this field.</div>
					</div>
				 <div class="add-comment-cmn__submit-icon">
					  <a href="javascript:void(0);" class="submit_reply" data-org_id="{{ $replies['org_id'] }}" data-id="{{ $replies['id'] }}" data-type="{{ $ptype }}" data-cid="{{ $parent_id }}" id="opp_reply{{ $replies['id'] }}"><i class="fas fa-paper-plane"></i></a>
				  </div>
			   </div>
		   </div>
		   
		@endforeach
   </div>
@endif

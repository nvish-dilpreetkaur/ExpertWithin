@if($opp_comments)
	@foreach($opp_comments as $comments)
	@php $last_comment_id = $comments['id']; @endphp
	<div class="opprtunity-comment">
			<div class="feed__view-comments-wrapper">
					 @if(!empty($comments['user']['profile']['image_name']))
					    @if(!empty($comments['user']['profile']['image_url']))
						<div class="comment-cmn__user-pic">
							<div class="favorite-page-cmn-card__user-pic" style="background:url('{{$comments['user']['profile']['image_url']}}')"></div>
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
						 {{$comments['user']['firstName']}}
				   </div>
					  {{$comments['comment']}}
				</div>
				<div class="feed-comments__replies">
				   <a class="cmmn__reply-action" data-toggle="collapse" 
				   href="#replyCollapsibleComment_{{$type}}{{$comments['id']}}" role="button" aria-expanded="false" 
				   aria-controls="replyCollapsibleComment">Reply</a>
					@if($comments['replies_count'] > 0)
					   | <a class="cmn__view-all-replies viewAllComments" id="viewAllComments{{$comments['id']}}" role="button" aria-expanded="false" 
					   aria-controls="viewAllComments">{{$comments['replies_count']}} Reply</a>
					@endif 
					@if($comments['replies_count'] > 1) 
					<div class="cmn-feed-card__load-prev-replies">
					   <a href="javascript:void(0);" class="load_prev_reply" data-id="{{$comments['id']}}" data-type="{{$type}}"  data-org_id="{{$comments['org_id']}}" data-prev_id="{{$comments['org_id']}}" id="load_prev_reply_{{$type}}{{$comments['id']}}">Load Previous Replies</a>
					</div> 
					<div class="replybox_{{$type}}{{$comments['id']}} well"></div>
					@endif
				</div>
			</div>
		   <!-----For Reply Button START-->
		     <div class="collapse replyCollapsibleComment" id="replyCollapsibleComment_{{$type}}{{$comments['id']}}">
				 <div class="card card-body com_rep">
					   <textarea class="form-control frminput" rows="1" cols="10" id="reply_{{$type}}{{ $comments['id'] }}" name="reply"></textarea>
						<div class="invalid-feedback" id="reply{{ $comments['id'] }}-error">Please fill out this field.</div>
					</div>
				 <div class="add-comment-cmn__submit-icon">
					 <a href="javascript:void(0);" class="submit_reply" data-org_id="{{ $comments['org_id'] }}" data-id="{{$comments['id']}}" data-type="{{$type}}" data-cid="{{ $comments['id'] }}" id="opp_comment{{ $comments['id'] }}"><i class="fas fa-paper-plane"></i></a>
				  </div>
			 </div>
		   <!-----For Reply Button END-->

		<!-----TO VIEW COMMENTS START-->
		
		   <div class="collapse show viewAllComments" id="viewAllReplies_{{$type}}{{$comments['id']}}">
			   @if($comments['replies_count'] > 0)
				   @php $last_id = 0; @endphp
				   @if($comments['replies'])
						@php $replies = $comments['replies']; 
						$last_id = $replies['id']; @endphp
						<div class="view_reply  feed__view-comments-wrapper">
							 @if(!empty($replies['user']['profile']['image_name']))
								@if(!empty($comments['user']['profile']['image_url']))
								<div class="comment-cmn__user-pic">
									<div class="favorite-page-cmn-card__user-pic" style="background:url('{{$replies['user']['profile']['image_url']}}')"></div>
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
							  href="#replyCollapsibleCommentSecondary_{{$type}}{{$replies['id']}}" role="button" aria-expanded="false" 
							  aria-controls="replyCollapsibleComment">Reply</a>
						   </div>
						   <div class="collapse replyCollapsibleCommentSecondary" id="replyCollapsibleCommentSecondary_{{$type}}{{$replies['id']}}">
							 <div class="card card-body com_rep">
									<textarea class="form-control frminput" rows="1" cols="10" id="reply{{ $replies['id'] }}" name="reply"></textarea>
									<div class="invalid-feedback" id="reply{{ $replies['id'] }}-error">Please fill out this field.</div>
								</div>
							 <div class="add-comment-cmn__submit-icon">
								 <a href="javascript:void(0);" class="submit_reply" data-org_id="{{ $comments['org_id'] }}" data-id="{{$replies['id']}}" data-type="{{$type}}" data-cid="{{ $comments['id'] }}" id="opp_reply{{ $replies['id'] }}"><i class="fas fa-paper-plane"></i></a>
								  
							  </div>
						   </div>
					   </div>
					   
					@endif 
					<input type="hidden" id="lastReplyid_{{$type}}{{$comments['id']}}" value="{{$last_id}}" > 
				@endif	 
		   </div>
		
	   
	   <!-----TO VIEW COMMENTS END-->
	</div>
	@endforeach
	@if($opp_comment_count > 2) 
	  <div class="cmn-feed-card__load-more-replies">
		 <a href="javascript:void(0);" class="load_more_comment" data-org_id="{{$org_id}}" id="load_more_comment_{{$type}}{{$org_id}}" data-type="{{$type}}">Load More Replies</a>
		 <input type="hidden" id="lastComments_{{$type}}{{$org_id}}" value="{{$last_comment_id}}" >  
	  </div>
	@endif  
@endif

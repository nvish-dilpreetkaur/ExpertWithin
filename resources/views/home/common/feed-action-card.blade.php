<div class="col-md-7">
	<div class="main-page-cmmn-feed-card__footer--social-icons ackn__sction-btns">
		  @if($feedVal['feed_user_action']['liked_feed'] == 1)
				<a href="javascript:void(0)" class="likeBtn{{$feedVal['id']}}" data-action="unlike"  data-feed_id="{{$feedVal['id']}}"><i class="fas fa-thumbs-up"></i></a>
		  @else
				 <a href="javascript:void(0)" class="likeBtn{{$feedVal['id']}}" data-action="like"  data-feed_id="{{$feedVal['id']}}"><i class="far fa-thumbs-up"></i></a>
		  @endif

		  @if ($feedVal['feed_type'] != 'new_ack_added')
			@if($feedVal['feed_user_action']['marked_as_fav'] == 1)
					<a href="javascript:void(0)" class="favBtn{{$feedVal['id']}}" data-action="unfav"  data-feed_id="{{$feedVal['id']}}"><i class="fas fa-heart"></i></a>
			@else
					<a href="javascript:void(0)" class="favBtn{{$feedVal['id']}}" data-action="fav"  data-feed_id="{{$feedVal['id']}}"> <i class="far fa-heart"></i></a>
			@endif
		  @endif

		  @if ($feedVal['feed_type'] == 'new_ack_added')
			<a data-toggle="collapse" 
			  href="javascript:void(0);" class="opp-comment" id="opp-comment{{$feedVal['id']}}" data-fid="{{ $feedVal['key_id'] }}" data-type="feed" role="button" aria-expanded="false" 
			  aria-controls="collapsibleComment">
			  <i class="far fa-comment"></i>
			</a>   
		 @else
			<a data-toggle="collapse" 
			  href="javascript:void(0);" class="opp-comment" id="opp-comment{{$feedVal['id']}}" data-fid="{{ $feedVal['key_id'] }}" data-type="opportunity" role="button" aria-expanded="false" 
			  aria-controls="collapsibleComment">
			  <i class="far fa-comment"></i>
			</a>   
		 @endif	                      
		  
		 
		   <a href="#mainPage__sharetoExpert" class="shareBtn{{$feedVal['id']}}" data-remote="{{ url('share-feed', Crypt::encrypt($feedVal['id'])) }}" data-toggle="modal" data-target="#mainPage__sharetoExpert" data-share_type="feed"><i class="far fa-share-square"></i></a> 
		   <?php /* <a href="javascript:void(0)" class="shareBtn{{$feedVal->id}}" data-remote="{{ url('share-feed', Crypt::encrypt($feedVal->id)) }}"  ><i class="far fa-share-square"></i></a>*/ ?>
	</div>
</div>
<!-----comment-Modal-START------>
@if ($feedVal['feed_type'] == 'new_ack_added')
	<div class="container">
		 <div class="collapse_feed collapse comment-wrapper__collapse-feed" id="collapsibleComment_feed{{ $feedVal['key_id'] }}">
			<div class="feed__add-comment-wrapper">
			  <div class="comment-cmn__user-pic">
				   <i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
			   </div>
			   <div class="card card-body com_rep">
				   <textarea class="form-control frminput" rows="1" cols="10" id="comment{{ $feedVal['key_id'] }}" name="comment"></textarea>
				   
				   <div class="invalid-feedback" id="comment{{ $feedVal['key_id'] }}-error">Please fill out this field.</div>
			   </div>
			   <div class="add-comment-cmn__submit-icon">
				  <a href="javascript:void(0);" class="submit_comment" data-id="{{ $feedVal['key_id'] }}" data-type="feed" id="opp_comment"><i class="fas fa-paper-plane"></i></a>
			   </div>
			   
			</div>
			<div id="show_comments_feed{{ $feedVal['key_id'] }}"></div>
			<div class="commentbox well"></div>
		</div> <!----#collapsibleCommentEND----->	
	</div>
@else
	<div class="container">
		 <div class="collapse_feed collapse comment-wrapper__collapse-feed" id="collapsibleComment_opportunity{{ $feedVal['key_id'] }}">
			<div class="feed__add-comment-wrapper">
			  <div class="comment-cmn__user-pic">
				   <i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
			   </div>
			   <div class="card card-body com_rep">
				   <textarea class="form-control frminput" rows="1" cols="10" id="comment{{ $feedVal['key_id'] }}" name="comment"></textarea>
				   
				   <div class="invalid-feedback" id="comment{{ $feedVal['key_id'] }}-error">Please fill out this field.</div>
			   </div>
			   <div class="add-comment-cmn__submit-icon">
				  <a href="javascript:void(0);" class="submit_comment" data-type="opportunity" data-id="{{ $feedVal['key_id'] }}" id="opp_comment"><i class="fas fa-paper-plane"></i></a>
			   </div>
			   
			</div>
			<div id="show_comments_opportunity{{ $feedVal['key_id'] }}"></div>
			<div class="commentbox well"></div>
		</div> <!----#collapsibleCommentEND----->	
	</div>
@endif	

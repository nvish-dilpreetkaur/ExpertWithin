<div class="col-md-5 for-null-paddng">
	@if($rowVal->opr_like == 1)
		<a href="javascript:void(0)" class="likeOppBtn{{ $rowVal->id }}" data-action="unlike"  data-oid="{{$rowVal->id}}"><i class="fas fa-thumbs-up"></i></a>
	@else
		<a href="javascript:void(0)" class="likeOppBtn{{$rowVal->id}}" data-action="like"  data-oid="{{$rowVal->id}}"><i class="far fa-thumbs-up"></i></a>
	@endif

	@if($rowVal->favourite == 1)
		<a href="javascript:void(0)" class="favOppBtn{{$rowVal->id}}" data-action="unfav"  data-oid="{{$rowVal->id}}"><i class="fas fa-heart"></i></a>
	@else
		<a href="javascript:void(0)" class="favOppBtn{{$rowVal->id}}" data-action="fav"  data-oid="{{$rowVal->id}}"> <i class="far fa-heart"></i></a>
	@endif

	<i class="far fa-comment"></i>
	<a href="#mainPage__sharetoExpert" class="shareBtn{{$rowVal->id}}" data-remote="{{ url('share-feed', Crypt::encrypt($rowVal->id)) }}" data-toggle="modal" data-target="#mainPage__sharetoExpert" data-share_type="OPP"><i class="far fa-share-square"></i></a> 
</div>
<!-----comment-Modal-START------>
<?php /*
<div class="container">
	 <div class="collapse_feed collapse comment-wrapper__collapse-feed" id="collapsibleComment{{ $feedVal['key_id'] }}">
		<div class="feed__add-comment-wrapper">
		  <div class="comment-cmn__user-pic">
			   <i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
		   </div>
		   <div class="card card-body">
			   <textarea class="form-control frminput" rows="1" cols="10" id="comment{{ $feedVal['key_id'] }}" name="comment"></textarea>
			   
			   <div class="invalid-feedback" id="comment{{ $feedVal['key_id'] }}-error">Please fill out this field.</div>
		   </div>
		   <div class="add-comment-cmn__submit-icon">
			  <a href="javascript:void(0);" class="submit_comment" data-id="{{ $feedVal['key_id'] }}" id="opp_comment"><i class="fas fa-paper-plane"></i></a>
		   </div>
		   
		</div>
		<div id="show_comments{{ $feedVal['key_id'] }}"></div>
		<div class="commentbox well"></div>
	</div> <!----#collapsibleCommentEND----->	
</div> 
*/?>
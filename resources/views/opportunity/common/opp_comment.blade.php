@if($all_comments)
	@foreach($all_comments as $comments)
		<div class="user-details-comments__modal--comments-wrapper">
			<div class="user-details-modal--comments-wrapper__user-pic">
					@if(!empty($comments['users']['profile']['image_name']))
					    @if(!empty($comments['users']['profile']['image_url']))
							<div class="favorite-page-cmn-card__user-pic" style="background:url('{{$comments['users']['profile']['image_url']}}')"></div>
						@else								
							<i class="fas fa-user-circle fa-1x" aria-hidden="true"></i>
						@endif
					 @else
						<i class="fas fa-user-circle fa-1x" aria-hidden="true"></i>
					 @endif
					<span class="user-details-modal--comments-wrapper__user-name">{{$comments['users']['firstName']}}</span>
			</div>
			<div class="user-details-modal--comments-wrapper__comment">
				{{$comments['comment']}}
			</div>            
		</div>
	@endforeach	
@endif		

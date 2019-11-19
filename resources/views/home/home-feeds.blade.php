	@if ($feedData != null)
	@if($totalPages > $page_no)
		<input type="hidden" value="{{ @$page_no }}" name="cur_page" id="cur_page">
		<input type="hidden" value="{{ @$totalPages }}" name="total_page" id="total_page">
	@endif
	@foreach($feedData as $feedKey => $feedVal)
		@if ($feedVal->feed_type == 'new_ack_added')
			<div class="main-page-cmmn-feed-card yellow-cmmn-feed-card">
				<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-ellipsis-h"></i>
				</div>
				<div class="dropdown-menu dots__options-list--for-feed">
					<ul>
					<li><a  href="http://google.com" class="remove_feed_link" data-id="{{ $feedVal->id }}">Remove from feed</a></li>
					<li><a href="http://google.com">Report</a></li>
					</ul>
				</div>
				<div class="main-page-cmmn-feed-card__desc">
				{{ '@'.$feedVal->ack_user.' '.$feedVal->ack_message }}
				</div>
				<div class="main-page-cmmn-feed-card__coins-info">
					<i class="fas fa-coins gold-coins-color"></i><span>25</span>
				</div>
			</div>
		@elseif ($feedVal->feed_type == 'new_published_opp')
			<div class="main-page-cmmn-feed-card main-page__cmmn-card">
				<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-ellipsis-h"></i>
				</div>
				<div class="dropdown-menu dots__options-list--for-feed">
					<ul>
					<li><a href="http://google.com" class="remove_feed_link" data-id="{{ $feedVal->id }}">Remove from feed</a></li>
					<li><a  href="http://google.com">Report</a></li>
					</ul>
				</div>
				
				<div class="main-page-cmmn-feed-card__top-blue-banner">
						<p>{{ $feedVal->rewards }}</p>
				</div>
				<div class="main-page-cmmn-feed-card__heading blue-txt-clr">
					{{ $feedVal->opportunity }}
				</div>
				<div class="main-page-cmmn-feed-card__desc">
					{{ char_trim($feedVal->opportunity_desc,105) }}
				</div>
				<div class="main-page-cmmn-feed-card__coins-info">
					<i class="fas fa-coins gold-coins-color"></i><span>{{ $feedVal->tokens }}</span>
				</div>
				<div class="main-page-cmmn-feed-card__footer-area--border"></div>
				<div class="main-page-cmmn-feed-card__footer-area">							
					<div class="row clearfix">
					<div class="col-md-1">
						<i class='fas fa-user-circle fa-2x'></i>
					</div>
					<div class="col-md-4">
						<div class="main-page-cmmn-feed-card__footer-area--desg">{{ $feedVal->opp_added_by }}</div> 
						<div class="main-page-cmmn-feed-card__footer-area--dept">{{ $feedVal->opp_dept }}</div>
					</div>
					<div class="col-md-7">
						<div class="main-page-cmmn-feed-card__footer--social-icons">
							@if($feedVal->liked_feed == 1)
								<a href="javascript:void(0)" class="likeBtn{{$feedVal->id}}" data-action="unlike" ><i class="fas fa-thumbs-up"></i></a>
							@else
							<a href="javascript:void(0)" class="likeBtn{{$feedVal->id}}" data-action="like" ><i class="far fa-thumbs-up"></i></a>
							@endif

							@if($feedVal->marked_as_fav == 1)
								<i class="fas fa-heart"></i>
							@else
								<i class="far fa-heart"></i>
							@endif
							
							<i class="far fa-comment"></i>
							<i class="far fa-share-square"></i>
						</div>
					</div>
					</div>
				</div>
			</div>
		@endif
	@endforeach
	@if($totalPages > $page_no)
		 <div id="load_more_wrapper" class="">
				<button type="button" name="load_more_button" class="" data-cur_page="{{ $page_no }}" data-total_page="{{ $totalPages }}" id="load_more_button">Load More</button>
		</div> 
	@else
		<div class="col-md-12 text-center">
			Oops! You have reached the end of the page.
		</div>
	@endif
@else
<div class="col-md-12 text-center">
	Oops! You have reached the end of the page.
</div>
@endif
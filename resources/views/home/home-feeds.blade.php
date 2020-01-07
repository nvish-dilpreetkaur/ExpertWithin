	@if ($feedData != null)
	@if($totalPages > $page_no)
		<input type="hidden" value="{{ @$page_no }}" name="cur_page" id="cur_page">
		<input type="hidden" value="{{ @$totalPages }}" name="total_page" id="total_page">
	@endif


	@foreach($feedData as $feedKey => $feedVal)
	
		<div id="parent-{{ $feedVal['id'] }}" class="{{ $feedVal['feed_type'].'_wrapper' }} ">
		@if ($feedVal['feed_type'] == 'new_ack_added')
			<div class="main-page__cmmn-card main-page-cmmn-feed-card home-feed__acknowledgement">
					
					<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-h"></i>
					</div>
					
					<div class="dropdown-menu dots__options-list--for-feed">
						<ul>
						<li><a href="javascript:void(0)" class="remove_feed_link" data-id="{{ $feedVal['id'] }}">Remove from feed</a></li>
						<li><a href="javascript:void(0)">Report</a></li>
						</ul>
					</div>
					<div class="main-page-cmmn-feed-card__desc">
					{{ ($feedVal['acknoledgement']['message']) ? '@'.$feedVal['acknoledgement']['ack_to']['firstName'].' '.char_trim($feedVal['acknoledgement']['message'],105) : '' }}
					</div>
					<div class="main-page-cmmn-feed-card__coins-info">
						<i class="fas fa-coins gold-coins-color"></i><span>25</span>
					</div>

				<!-- <div class="main-page-cmmn-feed-yellow-card__footer-area--border"></div> -->
				<div class="main-page-cmmn-feed__footer-area">							
					<div class="row clearfix">
					@if(!empty($feedVal['acknoledgement']['ack_by']['profile']['image_name']))
						<div class="col-md-1">
							<div class="favorite-page-cmn-card__user-pic" style="background:url('{{$feedVal['acknoledgement']['ack_by']['profile']['image_url']}}')"></div>
						</div>
				   @else
						<div class="col-md-1">
						<i class='fas fa-user-circle fa-2x'></i>
					</div>
				   @endif
					<div class="col-md-4">
						<div class="main-page-cmmn-feed-card__footer-area--desg">{{ $feedVal['acknoledgement']['ack_by']['firstName'] }}</div> 
						<div class="main-page-cmmn-feed-card__footer-area--dept">{{$feedVal['acknoledgement']['ack_by']['profile']['department'] }}</div>
					</div>
						@include('home.common.feed-action-card')
					</div>
				</div>
			</div>
		@elseif ($feedVal['feed_type'] == 'new_published_opp' && !empty($feedVal['opportunity']['opportunity']))
			<div class="main-page-cmmn-feed-card main-page__cmmn-card main-page-cmmn-feed-card__wrapper">
				<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-ellipsis-h" aria-hidden="true"></i>
				</div>
				<div class="dropdown-menu dots__options-list--for-feed">
					<ul>
					<li><a href="javascript:void(0)" class="remove_feed_link" data-id="{{ $feedVal['id'] }}">Remove from feed</a></li>
					<li><a href="javascript:void(0)" >Report</a></li>
					</ul>
				</div>
				
				<div class="main-page-cmmn-feed-card__top-heading azure-radiance-color-bg">
					<span>Apply by  {{ date_format(date_create($feedVal['opportunity']['apply_before']),"M d, Y") }}</span>
				</div>



				<div class="main-page-cmmn-feed__content-area">
					<div class="main-page-cmmn-feed__content-area--left-section">
						<div class="main-page-cmmn-feed-card__heading">
							@if(Auth::user()->id == $feedVal['opportunity']['org_uid']) 
							<a href="{{ url('create-opportunity', Crypt::encrypt($feedVal['opportunity']['id'])) }}">{{ $feedVal['opportunity']['opportunity'] }}</a>
							@else
							<a href="{{ url('view-opportunity', Crypt::encrypt($feedVal['opportunity']['id'])) }}">{{ $feedVal['opportunity']['opportunity'] }}</a>
							@endif
						</div>

						<div class="main-page-cmmn-feed-card__desc">
							{{ ($feedVal['opportunity']['opportunity_desc']) ? char_trim($feedVal['opportunity']['opportunity_desc'],80) : '' }}
						</div>

						@if(Auth::user()->id != $feedVal['opportunity']['org_uid']) 
							@if(($feedVal['opportunity']['user_actions']['apply'] == config('kloves.FLAG_SET'))  && ($feedVal['opportunity']['user_actions']['approve'] == config('kloves.OPP_APPLY_NEW') || $feedVal['opportunity']['user_actions']['approve'] == config('kloves.OPP_APPLY_APPROVED')) )
								<a id="withdrawCardBtn{{$feedVal['opportunity']['id']}}" class="main-page-cmmn-feed-card__action-btn"  data-oid="{{$feedVal['opportunity']['id']}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($feedVal['opportunity']['id'])) }}">{{ __('Withdraw') }}</a>
							@else
								<a id="applyCardBtn{{$feedVal['opportunity']['id']}}" class="main-page-cmmn-feed-card__action-btn"  data-oid="{{$feedVal['opportunity']['id']}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($feedVal['opportunity']['id'])) }}" >Interested ?</a>
								
							@endif
						@endif	
						<div class="main-page-cmmn-feed__content-area--left-section__list home-feed__opor-content">
							
							<ul>
								<li><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="common-semibold-heading">{{ $feedVal['opportunity']['tokens'] }}</span></li>
								<li class="common-semibold-heading">{{ $feedVal['opportunity']['expert_hrs'] }}/wk</li>
								<li><span class="common-semibold-heading">{{ ($feedVal['opportunity']['approved_applicants'])?count( $feedVal['opportunity']['approved_applicants']):0 }}</span> of <span class="common-semibold-heading">{{  ($feedVal['opportunity']['expert_qty']) ? $feedVal['opportunity']['expert_qty'] : '0'  }}</span> candidate(s)</li>
								<li><span class="common-semibold-heading">Reward:</span> {{ $feedVal['opportunity']['rewards'] }}</li>
							</ul>
						</div>
					</div>




					<div class="main-page-cmmn-feed__content-area--right-section">
						<div class="main-page-cmmn-feed__content-area--right-section__list">
							<span>Skills</span>
							
							@if($feedVal['opportunity']['skills'] != null)
								<ul>
									<?php $counterSkill = 0 ?>
									@foreach($feedVal['opportunity']['skills'] as $skillRow)
										<?php if($counterSkill >= 6){ break; } ?>
										<li><a href="javascript:void(0)">{{ $skillRow['name'] }}</a></li>
										<?php $counterSkill++; ?>
									@endforeach
									@if(count($feedVal['opportunity']['skills']) > 6)
										<li><a href="javascript:void(0)"  class="last-dot-li">[...]</a></li>
									@endif
								</ul>
							@endif
						</div>

						<div class="main-page-cmmn-feed__content-area--right-section__list">
							<span>Focus area</span>
							@if($feedVal['opportunity']['focus_areas'] != null)
							<ul>
								<?php $counterfocus = 0 ?>
								
									@foreach($feedVal['opportunity']['focus_areas'] as $focRow)
										<?php if($counterfocus >= 2){ break; } ?>
										<li><a href="javascript:void(0)">{{ $focRow['name'] }}</a></li>
										<?php $counterfocus++; ?>
									@endforeach
									
									@if(count($feedVal['opportunity']['focus_areas']) > 2)
											<li><a href="javascript:void(0)" class="last-dot-li">[...]</a></li>
									@endif
								
							</ul>
							@endif	
						</div>


					</div>
				</div>
	
				<div class="main-page-cmmn-feed-card__footer-area">							
					<div class="row clearfix">
						@if(!empty($feedVal['opportunity']['creator']['profile']['image_name']))
								<div class="col-md-1">
									<div class="favorite-page-cmn-card__user-pic" style="background:url('{{$feedVal['opportunity']['creator']['profile']['image_url']}}')"></div>
								</div>
						@else
								<div class="col-md-1">
								<i class='fas fa-user-circle fa-2x'></i>
							</div>
						@endif	

						<div class="col-md-4">
						<div class="main-page-cmmn-feed-card__footer-area--desg">{{ $feedVal['opportunity']['creator']['firstName'] }}</div> 
						<div class="main-page-cmmn-feed-card__footer-area--dept">{{ $feedVal['opportunity']['creator']['profile']['department'] }}</div>
						</div>

						@include('home.common.feed-action-card')
					</div>
				</div>
			</div>
		@endif
		</div>
	@endforeach

	
	@if($totalPages > $page_no)
		 <div id="load_more_wrapper" class="hidden">
				<button type="button" name="load_more_button" class="" data-cur_page="{{ $page_no }}" data-total_page="{{ $totalPages }}" id="load_more_button">Load More</button>
		</div> 
	@else
		<!--div id="caught_up" class="col-md-12 text-center">
			You're All Caught Up
		</div-->
	@endif
	<div class="box well"></div>
@else
<div class="col-md-12 text-center">
	You're All Caught Up
</div>
@endif

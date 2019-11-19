<div class="container">
	<div class="recently-viewed-oppor-section view-oppor-section">
		<h2>You may also like</h2>
		@if ($opp_you_may_like != null)
		<div class="row clearfix">
			@php $loopCounter2 = 0 @endphp
			@foreach($opp_you_may_like as $likeKey => $likeRow)
			@php $loopCounter2 = (($loopCounter2==6) ? 0 : $loopCounter2) @endphp
			<div class="col-md-4">

				<div class="card-common">
					<div class="card-hdng">
						<div class="card-title-area {{ $home_card_cls[$loopCounter2][0] }}">
							@php
							$img = $home_card_cls[$loopCounter2][1]
							@endphp
							<img src="{{ URL::asset('images') }}/{{ $home_card_cls[$loopCounter2][1] }}" class="card-book-pic">
							<div class="{{ $home_card_cls[$loopCounter2][2] }}">
									@foreach($opp_focus_list as $focRow)
									{{$focRow->name}}
									@endforeach
							</div>
						</div>

						<div class="start-end-date">
							<span class="start-date">Start: {{ date('m-d-y', strtotime($likeRow->start_date)) }}</span>
							<span class="end-date">End: {{ date('m-d-y', strtotime($likeRow->end_date)) }}</span>
						</div>
						<div class="card-heading-border"></div>
					</div>
					<h3><a href="{{ url('view-opportunity', Crypt::encrypt($likeRow->id)) }}">{{ $likeRow->opportunity }}</a></h3>
					<h5>{{ $likeRow->opportunity_desc }}</h5>
					
					@if(!$loggedInUserID)
						<a href="{{ ($loggedInUserID) ? '' : route('login') }}" class="common-card-apply-btn">Apply</a>
					@elseif($likeRow->apply == 0)
						<a class="applyBtn{{$likeRow->id}} common-card-apply-btn" title="{{ __('Apply') }}" data-oid="{{$likeRow->id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($likeRow->id)) }}">Apply</a>
					@else
						<a class="applyBtn{{$likeRow->id}} common-card-apply-btn appliedOpp{{$likeRow->id}}" href="javascript:void(0)">{{ __('Applied') }}</a>
					@endif
				
				
					
					<div class="card-apply-before-txt">Apply Before: {{ date('m-d-y', strtotime($likeRow->apply_before)) }}</div>
					<div class="card-heading-border"></div>
					<div class="card-footer">
						<div class="card-like common-card-footer" id="likeBtn{{$likeRow->id}}wrapper" data-likeurl="{{ url('opportunity/like', Crypt::encrypt($likeRow->id)) }}" data-unlikeurl="{{ url('opportunity/not_like', Crypt::encrypt($likeRow->id)) }}" data-likeimgurl="{{ URL::asset('images/thumbs-up-r.svg') }}" data-unlikeimgurl="{{ URL::asset('images/thumbs-up.svg') }}">
							<!-- mark like -->
							@if(!$loggedInUserID)
								<a href="{{ ($loggedInUserID) ? '' : route('login') }}"><img src="{{ URL::asset('images/thumbs-up.svg') }}"><p>Like</p></a>
							@elseif($likeRow->like == 0)
								<a title="{{ __('Like') }}" href="javascript:void(0)"  class="likeBtn{{$likeRow->id}}" data-action="like" >
								<img src="{{ URL::asset('images/thumbs-up.svg') }}"><p>Like</p>
								</a>
							@else
								<a title="{{ __('Like') }}" href="javascript:void(0)"  class="likeBtn{{$likeRow->id}}" data-action="unlike">
								<img src="{{ URL::asset('images/thumbs-up-r.svg') }}"><p>Like</p>
								</a>
							@endif
						</div>
						<!--div class="card-like common-card-footer"><img src="{{ URL::asset('images/thumbs-up.svg') }}">
							<p>Like</p>
						</div-->
						<div class="card-favorite common-card-footer" id="favBtn{{$likeRow->id}}wrapper" data-favurl="{{ url('opportunity/favourite', Crypt::encrypt($likeRow->id)) }}" data-unfavurl="{{ url('opportunity/not_favourite', Crypt::encrypt($likeRow->id)) }}" data-favimgurl="{{ URL::asset('images/heart-fill.svg') }}" data-unfavimgurl="{{ URL::asset('images/heart-outline.svg') }}">
							<!-- mark fav -->
							@if(!$loggedInUserID)
								<a href="{{ ($loggedInUserID) ? '' : route('login') }}"><img src="{{ URL::asset('images/heart-outline.svg') }}"><p>Favorite</p></a>
							@elseif($likeRow->favourite == 0)
							<a title="{{ __('Favourite') }}"  href="javascript:void(0)"  class="favBtn{{$likeRow->id}}" data-action="fav">
							  <img src="{{ URL::asset('images/heart-outline.svg') }}" ><p>Favorite</p>
							  </a>
				    @else
				    <a title="{{ __('Favourite') }}"  href="javascript:void(0)"  class="favBtn{{$likeRow->id}}" data-action="unfav">
					<img src="{{ URL::asset('images/heart-fill.svg') }}"><p>Favorite</p>
				    </a>
                            @endif
						</div>
						<!--div class="card-favorite common-card-footer"><img src="{{ URL::asset('images/heart-outline.svg') }}">
							<p>Favorite</p>
						</div-->
					</div>
				</div>
				<!----Card Common CLOSE -->

			</div>
			@php $loopCounter2++; @endphp
			@endforeach
		</div>
		@else
		<p>No recent viewed opportunities!</p>
		@endif
	</div>
</div>
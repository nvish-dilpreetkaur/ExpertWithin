@if ($youMayLikeOpp != null)

@foreach ($youMayLikeOpp as $likeRow =>  $likeVal)
    <div id="parent-{{ $likeVal->feed_id }}" class="main-page-cmmn-feed-card main-page__cmmn-card oppor-detail__cmmn-card dropdown">
            <div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fas fa-ellipsis-h"></i>
                              </div>
               <div class="dropdown-menu dots__options-list--for-feed dots__options-list--oppor-detail">
                  <ul>
                     <li><a href="javascript:void(0)" class="remove_feed_link" data-id="{{ $likeVal->feed_id }}">Remove from feed</a></li>
                     <li><a href="javascript:void(0)">Report</a></li>
                  </ul>
               </div>
            <!-- </div> -->
            <div class="main-page-cmmn-feed-card__top-blue-banner">
               <p>{{ $likeVal->rewards }}</p>
            </div>
            <div class="main-page-cmmn-feed-card__heading blue-txt-clr">
               <a href="{{ url('view-opportunity', Crypt::encrypt($likeVal->id)) }}">{{ $likeVal->opportunity }}</a>
            </div>
            <div class="main-page-cmmn-feed-card__desc">
                  {{ char_trim($likeVal->opportunity_desc,105) }}
            </div>
            <div class="main-page-cmmn-feed-card__coins-info">
               <i class="fas fa-coins gold-coins-color"></i><span>{{ $likeVal->tokens }}</span>
            </div>
            <div class="main-page-cmmn-feed-card__footer-area--border"></div>
            <div class="main-page-cmmn-feed-card__footer-area oppor-create-card__footer">
               <div class="row clearfix">
                      @if(!empty($likeVal->image_name))
							<div class="col-md-1">
							 <img src="{{$opportunity_data->image_name}}" style="width: 100%;">
						   </div>
					   @else
						<div class="col-md-1">
						 <i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
					   </div>
					   @endif
                  <div class="col-md-5">
                     <div class="main-page-cmmn-feed-card__footer-area--desg">{{ $likeVal->uname }}</div>
                     <div class="main-page-cmmn-feed-card__footer-area--dept">{{ $likeVal->department }}</div>
                  </div>
                  <div class="col-md-5">
                     @include('opportunity.common.feed-action-card')
                  </div>
               </div>
            </div>
     </div>
      <!------FEED-CARD-ENDS-HERE-->
   @endforeach
@else
   <div class="">Nothing to show!</div>
@endif

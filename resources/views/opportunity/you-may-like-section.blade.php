@if ($youMayLikeOpp != null)

@foreach ($youMayLikeOpp as $likeRow =>  $likeVal)
    <div id="parent-{{ $likeVal->feed_id }}" class="main-page-cmmn-feed-card main-page__cmmn-card oppor-detail__cmmn-card dropdown you-may-like__widget">
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
            <div class="main-page-cmmn-feed-card__top-blue-banner azure-radiance-color-bg ">
               <p>Apply by {{ date("d M, Y",strtotime($likeVal->apply_before)) }}</p>
            </div>
            <div class="main-page-cmmn-feed-card__heading blue-txt-clr">
               <a href="{{ url('view-opportunity', Crypt::encrypt($likeVal->id)) }}">{{ $likeVal->opportunity }}</a>
            </div>
            <div class="main-page-cmmn-feed-card__desc">
                  {{ char_trim($likeVal->opportunity_desc,105) }}
            </div>

            <div class="like-block__apply-action">
            @if(Auth::user()->id != $likeVal->org_uid && empty($likeVal->job_start_date) && empty($likeVal->job_complete_date)) 
               @if(($likeVal->apply == config('kloves.FLAG_SET'))  && ($likeVal->approve == config('kloves.OPP_APPLY_NEW') || $likeVal->approve == config('kloves.OPP_APPLY_APPROVED')) )
                  <a id="withdrawCardBtn{{$likeVal->id}}" class="main-page-cmmn-feed-card__action-search-btn" data-oid="{{$likeVal->id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($likeVal->id)) }}">{{ __('Withdraw') }}</a>
               @else
                  <a id="applyCardBtn{{$likeVal->id}}" class="main-page-cmmn-feed-card__action-search-btn"  data-oid="{{$likeVal->id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($likeVal->id)) }}" >
                  <span>Interested ?</span>
               </a>
               @endif 
            @else
               <a href="javascript:void(0)" class="main-page-cmmn-feed-card__action-search-btn-none" style="cursor:none">&nbsp;</a>				
            @endif 
            </div>

            <div class="favorite_page--cntnt__list">
               <ul>
                  <li><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="common-semibold-heading">{{$likeVal->tokens}}</span></li>
                  <li class="common-semibold-heading">{{$likeVal->expert_hrs}}hrs/wk</li>
                  <li><span class="common-semibold-heading">{{$likeVal->approved_users}}</span> of <span class="common-semibold-heading">{{(!empty($likeVal->expert_qty))?$likeVal->expert_qty:0 }}</span> candidate(s)</li><br/>
                  <li><span class="common-semibold-heading">Reward:</span> {{$likeVal->rewards}} </li>
               </ul>
            </div>
            <div class="main-page-cmmn-feed-card__footer-area--border"></div>
            <div class="main-page-cmmn-feed-card__footer-area oppor-create-card__footer">
               <div class="row clearfix">
                      @if(!empty($likeVal->image_name))
							<div class="col-md-1">
                     <div class="publish-page-cmn-card__user-pic" style="background: url('{{$opportunity_data->image_name}}') ;"></div>
							 <!-- <img src="{{$opportunity_data->image_name}}" style="width: 100%;"> -->
						   </div>
					   @else
						<div class="col-md-1">
						 <i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
					   </div>
					   @endif
                  <div class="col-md-5 like-opr__user-details">
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

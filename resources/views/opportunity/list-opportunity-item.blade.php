@if(count($opportunities)>0)
@foreach($opportunities as $rowKey => $rowVal)
<div class="col-md-4 for-null-paddng-right">
    <div class="main-page-cmmn-feed-card main-page__cmmn-card favorites-cmmn__cards opportunities__page--cmmn-cards">

        <div class="favorites-cmmn__cards--dots-menu">
            <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
        </div>
        <div class="favorite-page-cmmn-card__heading for-element-with--blue-marguerite-bg">
            Apply by {{ date_format(date_create($rowVal->apply_before),"M d, Y") }}
        </div>

        <div class="main-page-cmmn-feed__content-area favorite_page--cntnt">

            <div class="main-page-cmmn-feed-card__heading">
                <a href="{{ url('view-opportunity', Crypt::encrypt($rowVal->id)) }}">{{ (strlen($rowVal->opportunity)<=25)?$rowVal->opportunity:char_trim($rowVal->opportunity,25) }}</a>
            </div>
            <div class="main-page-cmmn-feed-card__desc">
            {{ (strlen($rowVal->opportunity_desc)<=50)?$rowVal->opportunity_desc:char_trim($rowVal->opportunity_desc,50) }}
            </div>
            <!-- <a class="main-page-cmmn-feed-card__action-btn favorite--card-action__button" href="#">Interested ?</a> -->
            
            @if(Auth::user()->id != $rowVal->org_uid && empty($rowVal->job_start_date) && empty($rowVal->job_complete_date)) 
                @if(($rowVal->apply == config('kloves.FLAG_SET'))  && ($rowVal->approve == config('kloves.OPP_APPLY_NEW') || $rowVal->approve == config('kloves.OPP_APPLY_APPROVED')) )
                    <a id="withdrawCardBtn{{$rowVal->id}}" class="main-page-cmmn-feed-card__action-btn favorite--card-action__button"  data-oid="{{$rowVal->id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($rowVal->id)) }}">{{ __('Applied') }}</a>
                @else
                    <a id="applyCardBtn{{$rowVal->id}}" class="main-page-cmmn-feed-card__action-btn favorite--card-action__button"  data-oid="{{$rowVal->id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($rowVal->id)) }}" >
                    <span>Interested ?</span>
                </a>
                @endif
            @else
				<a href="javascript:void(0)" class="main-page-cmmn-feed-card__action-search-btn-none" style="cursor:none">&nbsp;</a>
            @endif

            <div class="favorite_page--cntnt__list">
                <ul>
                    <li><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="common-semibold-heading">{{$rowVal->tokens}}</span></li>
                    <li class="common-semibold-heading">{{$rowVal->expert_hrs}}hrs/wk</li>
                    <li><span class="common-semibold-heading">{{$rowVal->approved_users}} </span> of <span class="common-semibold-heading">{{(!empty($rowVal->expert_qty))?$rowVal->expert_qty:0 }}</span> candidate(s)</li>
                    <li><span class="common-semibold-heading">Reward:</span> {{$rowVal->rewards}} </li>
                </ul>
            </div>

        </div>

        <div class="main-page-cmmn-feed-card__footer-area favorite-card__footer-area">
            <div class="row ">
                <div class="col-md-1">
                    
                        @if(!empty($rowVal->image_name))
                            <div class="favorite-page-cmn-card__user-pic" style="background: url('{{ $rowVal->image_name }}');">
                            </div>
                        @else
                            <div class="favorite-page-cmn-card__user-pic"><i class="fas fa-user-circle fa-2x" aria-hidden="true"></i></div>
                        @endif
                    
                </div>

                <div class="col-md-5 for-null-paddng-right">
                    <div class="main-page-cmmn-feed-card__footer-area--desg">{{$rowVal->firstName}}</div>
                    <div class="main-page-cmmn-feed-card__footer-area--dept">{{$rowVal->department}}</div>
                </div>


                <div class="col-md-5 for-null-paddng">
                    <div class="main-page-cmmn-feed-card__footer--social-icons">
                        <!----------------------------------------------------------->
                        <a href="#"><i class="far fa-thumbs-up" aria-hidden="true"></i></a>
                        <a href="#"><i class="fas fa-heart" aria-hidden="true"></i></a>
                        <i class="far fa-comment" aria-hidden="true"></i>
                        <a href="#"><i class="far fa-share-square" aria-hidden="true"></i></a>
                        <!-------------------------------------------------------->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endforeach
@endif

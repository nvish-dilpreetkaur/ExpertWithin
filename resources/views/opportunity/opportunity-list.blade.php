@extends('layouts.app') @section('content')
<div class="container">
    <div class="row clearfix">
        <div class="main-contnt-body opportunity__list">
            <div class="opportunities__wrapper">
                <div class="row">

                    <div class="col-md-9">

                        <div class="middle-section__cmmn-card">
                            <p>What would you like to do today?</p>
                            @if (in_array(config('kloves.ROLE_MANAGER'), $userRoles) || in_array(config('kloves.ROLE_ADMIN'), $userRoles))
                            <div class="middle-section__top-card--cmmn-button" data-toggle="modal" data-target="#mainPage__createOpportunity">
                                <i class="fas fa-door-open" aria-hidden="true"></i><sup>+</sup>
                                <a href="#"></a>
                            </div>
                            @endif
                            <div class="middle-section__top-card--cmmn-button" data-toggle="modal">
                                <a href="#" id="acknowledgeAnExpert" data-target="mainPage__acknowledgeAnExpert"><i class="fas fa-trophy"></i><sup>+</sup></a>
                            </div>
                        </div>

                        <div class="opportunities__wrapper--seacrh-section">
                            <p>Your time is valued, search away…</p>

                            <!---------SEARCH BAR WITH DROPDOWN--START------>

                            <form class="opportunities-page__search-form">
                                <div class="search-drawer-input">
                                    <input type="text" id="search__data-field" class="form-control">
                                    <i class="fas fa-times" id="search__clear-data-field" style="display:none;" aria-hidden="true"></i>
                                </div>
                                <div class="search-drawer-content-btn">
                                    <button type="button" id="search__btn" class="search-drawer-btn">Search</button>
                                </div>
                            </form>

                            <!---------SEARCH BAR WITH DROPDOWN-END------->
                            <div class="opportunities__wrapper--seacrh-section__suggested-searches">
                                <p>Suggested opportunity searches</p>
                                <div class="cmmn__pills opportunities-page__cmmn-pills">
                                    <ul id="opor-list__focus-area"></ul>
                                </div>
                            </div>
                        </div>

                        <div class="opportunities__wrapper--seacrh-section__suggested-searches--cards">
                            <div class="search-drawer-cards">

                                <div class="container">
                                    <p>Based on your profile</p>
                                    <div class="row clearfix" id="search__opportunity-content">
                                        <!------------------------1----------------------------------->
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
															<a id="withdrawCardBtn{{$rowVal->id}}" class="main-page-cmmn-feed-card__action-btn favorite--card-action__button"  data-oid="{{$rowVal->id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($rowVal->id)) }}">{{ __('Withdraw') }}</a>
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
																	<div class="favorite-page-cmn-card__user-pic"  style="background: url('{{ $rowVal->image_name }}');">
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
										@elseif($page==1)
											<div class="container"><p>No more opportunities found!</p></div>
										@endif

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="main-page__cmmn-card cmmn-card__-title-subtitle" id="opp-for-candidate">
                            @include('home.opp-for-candidate')
                        </div>
                        @include('home.my-applied-opp')
                    </div>

                </div>
            </div>
        </div>
        <!------CREATE-OPPORTUNITY_MODAL_-START------>
        <!-- The Modal -->
        <div class="modal fade main-page__cmmn_modal" id="mainPage__createOpportunity">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Let’s begin</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ route('add-opportunity') }}" method="POST" id="opportunity-create" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <div class="to-cmbine-the-label-txt">
                                    <label for="otitle">Title</label>
                                    <input type="text" class="form-control" id="otitle" placeholder="UX/UI Designer" name="otitle" required>
                                </div>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <div class="to-cmbine-the-label-txt">
                                    <label for="odesc">Describe:</label>
                                    <textarea rows="4" cols="50" class="form-control" id="odesc" name="odesc" placeholder="The UX/UI Designers will be responsible for collecting, researching, investigating and evaluating user requirements. Their responsibility is to deliver an outstanding user experience providing an exceptional and intuitive application design."
                                        required></textarea>
                                </div>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group form-check">
                            </div>
                            <div class="main-page__form-buttons">
                                <button type="submit" id="btn-opr-later" class="btn btn-primary" value="save-for-later">Save for later</button>
                                <button type="submit" id="btn-opr-cont" class="btn btn-primary" value="continue">Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!------ACKNOWLEDGE_AN_EXPERT_MODAL_-START------>
        <!-- The Modal -->
        <div class="modal fade main-page__cmmn_modal" id="mainPage__acknowledgeAnExpert">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div id="thanks_up" class="hidden"></div>
                    <div id="acknowledge">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Brighten someone’s day with an acknowledgement</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade main-page__cmmn_modal" id="opportunity__success">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div id="thanks_up" class="hidden"></div>
                    <!-- Modal body -->
                    <div class="modal-body text-center"><b>Opportunity Saved Successfully!</b></div>
                </div>
            </div>
        </div>

		<script src="{{ URL::asset('js/opportunity.js') }}"></script>
		
		<script>
		$(document).ready(function() {
			$.ajax({
				type: "GET",
				url: SITE_URL+"/focus-areas",
				success: function(data){
					if(data.status==true) {
						var focusAreaHtml = "";
						$.each(data.response.focusArea, function( index, value ) {
							focusAreaHtml += '<li class="search__focus-area" data-fid="'+value.tid+'"><a href="javascript:void(0)">'+value.name+'</a></li>';
						});
						$("#opor-list__focus-area").html(focusAreaHtml);
					}
				}
			});

			var selectedFocusArea = [];
			var searchText = "";
			var page = 2;
			var hasMoreData = true;

			function makeSearchCall() {
				page = 1;
				searchText = document.getElementById("search__data-field").value;
				if(searchText.length > 0) {
					$("#search__clear-data-field").show();
				} else {
					$("#search__clear-data-field").hide();
				}
				$.ajax({
					type: "POST",
					url: SITE_URL+"/search",
					data: { "search_text": searchText, "focus_area": selectedFocusArea, "page": page, "action": "list" },
					success: function(data){
						if(data.status==true) {
							page++;
							hasMoreData = data.hasMoreData;
							$("#search__opportunity-content").html(data.html);
						}
					}
				});
			}

			$(document).on("click", ".search__focus-area", function() {
				page = 1;
				let fid = $(this).data('fid');
				if($(this).hasClass("active")) {
					// Remove From focus Area list
					$(this).removeClass("active");
					selectedFocusArea.splice( $.inArray(fid, selectedFocusArea), 1 );
				} else {
					// Add to focus Area List
					$(this).addClass("active");
					selectedFocusArea.push(fid);
				}

				makeSearchCall();
			});

			$(document).on("click", "#search__btn", function() {
				makeSearchCall();
			});

			$(document).on('keyup change','#search__data-field', function() {
				makeSearchCall();
            });
            
            $('#search__data-field').keypress(function(e){
                if(e.which === 13) {
                    e.preventDefault();
                }
            });

			$(document).on("click", "#search__clear-data-field", function() {
				document.getElementById("search__data-field").value = "";
				makeSearchCall();
			});

			$(window).on('scroll', function() {
				if (Math.ceil($(window).scrollTop()) + Math.ceil($(window).height()) >= Math.ceil($(document).height())) {
					if(hasMoreData==true) {
						//console.log(page,"-------");
						$.ajax({
							type: "POST",
							url: SITE_URL+"/search",
							data: { "search_text": searchText, "focus_area": selectedFocusArea, "page": page, "action": "list" },
							success: function(data){
								if(data.status==true) {
									page++;
									hasMoreData = data.hasMoreData;
									$("#search__opportunity-content").append(data.html);
								}
							}
						});
					} else {
						console.log("No More Data To Show");
					}
				}

			});

		});
		</script>
        @endsection

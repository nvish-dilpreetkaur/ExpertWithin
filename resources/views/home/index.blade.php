@extends('layouts.app')
@section('content')	
	<!-- Page Content  -->
<div class="container">
	<div class="row clearfix">
	<div class="main-contnt-body" id="main-page">
		<div class="row">
		<!--LEFT-SECTION-->
				<div class="main-page__left-section--outer">
					<div class="fixme">
						<div class="main-page__cmmn-card">
							@include('home.common.daily-digest')
						</div>
						<!----My applied opportunities--->
						@include('home.my-applied-opp')
						<!------->
						<div class="main-page__cmmn-card cmmn-card__-title-subtitle hidden">
								<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fas fa-ellipsis-h"></i>
									<div class="dropdown-menu dots__options-list dots__options-list--for-left-section">
										<ul>
											<li>Sort by</li>
											<li><a href="#">Draft</a></li>
											<li><a href="#">Publish</a></li>
											<li><a href="#">Screen</a></li>
											<li><a href="#">Complete</a></li>
											<li><a href="#">Cancel</a></li>
										</ul>
									</div>
								</div>
								<div class="main-page__cmmn-card--heading"><i class="fas fa-briefcase"></i><span>Job openings for you</span></div>
								<p class="blue-txt-clr">Solutions Architect</p>
								<p class="grey-txt-clr"> Operations</p>
		
								<p class="blue-txt-clr">Sr. Web Designer</p>
								<p class="grey-txt-clr"> Facilities</p>
		
								<p class="blue-txt-clr">Lead Art Director</p>
								<p class="grey-txt-clr">Sales & Marketing</p>
								
						</div>
					</div>
				</div>
	<!--MIDDLE-SCROLL-SECTION-->
				<div class="main-page__middle-section--outer">
					<div class="middle-scroll-section__outer">
						<div class="middle-section__cmmn-card main-page__btn-section">
							<p>What would you like to do today?</p>
							@if (in_array(config('kloves.ROLE_MANAGER'), $userRoles) || in_array(config('kloves.ROLE_ADMIN'), $userRoles))
							<div class="middle-section__top-card--cmmn-button" data-toggle="modal" data-target="#mainPage__createOpportunity">
							<i class="fas fa-door-open" aria-hidden="true"></i><sup>+</sup><a href="#"></a>
							</div>
							@endif
							<div class="middle-section__top-card--cmmn-button" data-toggle="modal">
							<!-- <i class="fas fa-trophy"></i><sup>+</sup><a href="#" id="acknowledgeAnExpert" data-target="mainPage__acknowledgeAnExpert"></a> -->
							<a href="#" id="acknowledgeAnExpert" data-target="mainPage__acknowledgeAnExpert"><i class="fas fa-trophy"></i><sup>+</sup></a>
							</div>
						</div>
						<!--------->
						<div class="middle-section__cmmn-card for-swiper-slider-bg" >
								<p>{{ ($topMatchedOpportunities != null) ? "Top opportunities for you" : "No  opportunities for you" }}</p>

								@if ($topMatchedOpportunities != null)
								<div class="swiper-container">
									<div class="swiper-wrapper">
									@foreach ($topMatchedOpportunities as $topOppRow)
										<div class="swiper-slide">
											<div class="main-page-cmmn-slider__top-white-banner">
													<!-- {{ $topOppRow->rewards }} -->
													<div>Apply by</div>{{ date_format(date_create($topOppRow->apply_before),"M d, Y") }}
											</div>
											<div class="main-page-slider__cntnt">
													<a href="{{ url('view-opportunity', Crypt::encrypt($topOppRow->id)) }}">{{ $topOppRow->opportunity }}</a>
											</div>	
											<!-- <div class="main-page-slider__cntnt__coins-info">
													<i class="fas fa-coins gold-coins-color"></i><span>{{ $topOppRow->tokens }}</span>
											</div> -->
										</div>
									@endforeach
									</div>
								</div>
								<!-- Add Arrows -->
								<div class="swiper-button-next"></div>
								<div class="swiper-button-prev"></div> 
								@endif
						</div>
						<!-------->
						<div class="to-sort-feed">
							<span>Sort feed by</span>
							<i class="fas fa-sliders-h"></i>
						</div>
						<!----1-->
						<div id="home-feed">
							@include('home.home-feeds')
						</div>
				
					</div>
				</div>
	<!--RIGHT-SECTION-->
				<div class="main-page__right-section--outer">
				<div class="fixme-rite-sec">
					<div class="main-page__cmmn-card main-page__user-info-card">
						<div class="container">
						<div class="row clearfix">
							<div class="col-md-4">
							   @if(!empty($current_user_detail['profile']['image_name']))
									<div class="main-page__user-info-card__picture" style="background-image: url('{{$current_user_detail['profile']['image_url']}}');"><i class=''></i></div>
							   @else
									<div class="main-page__user-info-card__picture"><i class="fas fa-user-circle fa-4x" aria-hidden="true"></i></div>
							   @endif
							</div>
	
							<div class="col-md-8 for-null-paddng-right">
								<div class="main-page__user-info-card__about">
									<div class="main-page__user-info-card--title">{{ Auth::user()->firstName }}</div>
									<div class="main-page__user-info-card--desc">{{ $current_user_detail['profile']['about'] }}</div>
									<div class="view-profile-link"><a href="{{route('profile')}}">My profile</a></div>
								</div>
							</div>
	
							<div class="main-page__user-info-card__stats widget__my-profile">
									<div class="user-info-card__stats--title">
										<i class="fas fa-eye"></i><span> Who’s viewed your profile:</span>
									</div>
									<div class="user-info-card__stats--numbers">
											<span>13</span>
									</div>
	
									<div class="user-info-card__stats--title">
										<i class="fas fa-user-friends"></i><span> My Team:</span>
									</div>
									<div class="user-info-card__stats--numbers">
											<span>6</span>
									</div>
	
									<!-- <div class="user-info-card__stats--title">
										<i class="fas fa-user-plus"></i><span>Following:</span>
									</div>
									<div class="user-info-card__stats--numbers">
										<span>8</span>
									</div> -->
							</div>
	
							<div class="main-page__user-info-card__expert-tokens">
									<div class="expert-tokens__stats--title-section">
											<div class="expert-tokens__stats--title">
												<i class="fas fa-coins gold-coins-color"></i><span> Expert Tokens</span>
											</div>
											<div class="expert-tokens__stats--sub-title">
												<p>Use your tokens</p>
											</div>
									</div>
	
									<div class="expert-tokens__stats--numbers-section">
											<div class="expert-tokens__stats--numbers">
													<span>33</span>
											</div>
											<div class="expert-tokens__stats--numbers">
												<p class="sub-title">Total tokens</p>
											</div>
									</div>
	
							</div>
	
						</div>
						</div>
					</div><!--main-page__user-info-card-->
					
						<div class="main-page__cmmn-card hidden">
							<div class="main-page__cmmn-card--heading"><i class="fas fa-cubes"></i> <span>My skills & certifications</span></div>
							<div class="main-page__cmmn-card--my-skills">
								<div class="my-skills__title">UI/UX <span class="my-skills__points"> • 23</span></div>
							</div>
							<div class="main-page__cmmn-card--my-skills">
								<div class="my-skills__title">Front-end Development <span class="my-skills__points"> • 100</span></div>
							</div>
						</div>
						<!------->
	
						<!---My opportunities for candidates---->
						@if(!empty($myOppForCandidates))
						<div class="main-page__cmmn-card cmmn-card__-title-subtitle" id="opp-for-candidate">
							@include('home.opp-for-candidate')
						</div>
						@endif
					</div>
				</div>
				<div class="col-md-2" style="display: none;"></div>
		</div>
	</div>
	</div>
</div>
	
	<!---Content Closed-->

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
							  <textarea rows="4" cols="50" class="form-control" id="odesc" name="odesc" placeholder="The UX/UI Designers will be responsible for collecting, researching, investigating and evaluating user requirements. Their responsibility is to deliver an outstanding user experience providing an exceptional and intuitive application design." required></textarea>		
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
	  
<script src="{{ URL::asset('js/jm.spinner.js') }}"></script>
<script src="{{ URL::asset('js/opportunity.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
	$(window).on('scroll', function() {
        if (Math.ceil($(window).scrollTop()) + Math.ceil($(window).height()) >= Math.ceil($(document).height())) {
            if (hasData == true && isLoading == false) {
                $('.box').jmspinner('small');
                var cur_page = $('#cur_page').val();
                var total_page = $('#total_page').val(); //console.log('cur_page'+cur_page) ;  console.log('total_page'+total_page);
                setTimeout(function() {
                    console.log(cur_page);
                    var page_no = parseInt(cur_page) + 1;
                    if (cur_page != page_no) {
                        load_feed_data(page_no, total_page);
                    }
                }, 500);
            }
        }
	});

	function load_feed_data(page_no, total_page) {
        isLoading = true;
        $.ajax({
            url: "{{ route('home') }}",
            type: "POST",
            data: {
                page_no: page_no,
                totalPages: total_page
            },
            beforeSend: function() {

            },
            error: function() {

            },
            success: function() {

            },
            complete: function(data) {
                var obj = $.parseJSON(data.responseText);
                //$('#load_more_wrapper').remove();
                if (obj.feed == true) {
                    $('#home-feed').append(obj.html);
                    var cur_page = $('#cur_page').val(page_no);
                    hasData = true;
                } else {
                    if (!$('#caught_up').length) {
                        //$('#home-feed').append('<div id="caught_up" class="col-md-12 text-center">You\'re All Caught Up</div>');
                    }
                    hasData = false;
                }
                isLoading = false;
                $('.box').jmspinner(false);
            },
        });
    }

	function remove_feed(feed_id) {
        $.ajax({
            url: "{{ route('feed-action') }}",
            type: "POST",
            data: {
                'feed_id': feed_id,
                'action': 'remove_feed'
            },
            beforeSend: function() {},
            error: function() {},
            success: function() {},
            complete: function(data) {
                var obj = $.parseJSON(data.responseText); //console.log(obj)
                if (obj.type = 'success') {
					//$('#parent-' + feed_id).html(obj.feed_html);
					$('#parent-' + feed_id).html("");
                }
                //$('#home-feed').append(obj.html);
            },
        });
    }


    $(document).on('click', '#load_more_button', function() {
        var cur_page = $(this).data('cur_page');
        var total_page = $(this).data('total_page');
        //var page_no = parseInt(cur_page) + 1;
        $('#load_more_button').html('<b>Loading...</b>');
        load_feed_data(page_no, total_page);
    });

    $(document).on('click', '.remove_feed_link', function() {
        var feed_id = $(this).data('id');
        remove_feed(feed_id);
	});
});
	
function initVueComponent(){
	//<![CDATA[
      // $shareUserList['all']
      vm = new Vue({
            el: '#vueComponent',
            data: {
			search : '',
			selectedList : [],
			postIDs : [],
                  items: {!! $shareUserJsonList !!},
            },
          /*created: function () {
            // `this` points to the vm instance
            console.log('a is: ' + this.a)
            },*/
            computed: {
                  filteredList() {
                        return this.items.filter(itemVal => {
                        return itemVal.firstName.toLowerCase().includes(this.search.toLowerCase())
                        })
                  }
		},
            methods: {
                 selectRecord( item ){
				var indexOfSelectedItem = this.items.indexOf(item);
				if (indexOfSelectedItem > -1) {
					this.items.splice(indexOfSelectedItem, 1);
					this.selectedList.push( item );
					this.postIDs.push( item.id );
					$("#checkedUsers").val(this.postIDs.toString());
					//$("#checkedUsers").val(($("#checkedUsers").val() + ', ' + item.id).replace(/^, /, ''));
				}
				this.search = '';
		     },
		     removeRecord( item ){ 
				var indexOfSelectedItem = this.selectedList.indexOf(item); 
				if (indexOfSelectedItem > -1) {  //console.log('sss'+indexOfSelectedItem)
					this.items.push( item );

					this.selectedList.splice(indexOfSelectedItem, 1);
					this.postIDs.splice(indexOfSelectedItem, 1);
					$("#checkedUsers").val(this.postIDs.toString());
				}
				this.search = '';
		     },
		     sendInAjax(){

		     }
            }
	});
	//]]>
}
</script>
@endsection

@extends('layouts.app')
@section('content')	
	<!-- Page Content  -->
<div class="container">
	<div class="row clearfix">
	<div class="main-contnt-body" id="main-page">
		<div class="row">
		<!--LEFT-SECTION-->
				<div class="main-page__left-section--outer">
					<div class="main-page__cmmn-card">
					<div class="main-page__cmmn-card--heading"><i class="fas fa-newspaper"></i><span>Daily Digest – {{ $todatTime = Carbon\Carbon::now()->format('D, F d, Y') }}</span></div>
							<ul>
								<li>You have <span class="blue-txt-clr">1 Open Opportunity</span> in draft.</li>
								<li><span class="blue-txt-clr">Acknowledge </span> Mock Choi for completing an opp</li>
								<li><span class="blue-txt-clr">Natasha Vargas</span> acknowledged you.</li>
								<li>There are <span class="blue-txt-clr">2 new opportunities </span> related to your skill sets, focus areas</li>
							</ul>
							<div class="main-page__cmmn-card--footer">
								<p class="show-more">Show More</p>
							</div>
					</div>
					<div class="fixme">
						<!----My applied opportunities--->
						@include('home.my-applied-opp')
						<!------->
						<div class="main-page__cmmn-card cmmn-card__-title-subtitle">
								<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fas fa-ellipsis-h"></i>
									<div class="dropdown-menu dots__options-list dots__options-list--for-left-section">
										<ul>
											<li><a href="#">Sort by</a></li>
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
						<div class="middle-section__cmmn-card">
							<p>What would you like to do?</p>
							<div class="middle-section__top-card--cmmn-button" data-toggle="modal" data-target="#mainPage__createOpportunity">
								<i class="fas fa-pencil-alt"></i><a href="#">Create an Opportunity</a>
							</div>
							<div class="middle-section__top-card--cmmn-button" data-toggle="modal">
								<i class="fas fa-pencil-alt"></i><a href="#" id="acknowledgeAnExpert">Acknowledge an Expert</a>
							</div>
						</div>
						<!--------->
						<div class="middle-section__cmmn-card" >
								<p>{{ ($topMatchedOpportunities != null) ? "Top opportunities for you" : "No  opportunities for you" }}</p>

								@if ($topMatchedOpportunities != null)
								<div class="swiper-container">
									<div class="swiper-wrapper">
									@foreach ($topMatchedOpportunities as $topOppRow)
										<div class="swiper-slide">
											<div class="main-page-cmmn-slider__top-white-banner">
													{{ $topOppRow->rewards }}
											</div>
											<div class="main-page-slider__cntnt">
													<a href="{{ url('view-opportunity', Crypt::encrypt($topOppRow->id)) }}">{{ $topOppRow->opportunity }}</a>
											</div>	
											<div class="main-page-slider__cntnt__coins-info">
													<i class="fas fa-coins gold-coins-color"></i><span>{{ $topOppRow->tokens }}</span>
											</div>							
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
					<div class="main-page__cmmn-card main-page__user-info-card">
						<div class="container">
						<div class="row clearfix">
							<div class="col-md-3">
								<div class="main-page__user-info-card__picture">
									<i class=''></i>
								</div>
							</div>
	
							<div class="col-md-9">
								<div class="main-page__user-info-card__about">
									<div class="main-page__user-info-card--title">{{ Auth::user()->firstName }}</div>
									<div class="main-page__user-info-card--desc">Transform high-level requirements into simple solutions.</div>
									<div class="view-profile-link"><a href="#">My profile</a></div>
								</div>
							</div>
	
							<div class="main-page__user-info-card__stats">
									<div class="user-info-card__stats--title">
										<i class="fas fa-eye"></i><span> Who’s viewed your profile</span>
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
	
									<div class="user-info-card__stats--title">
										<i class="fas fa-user-plus"></i><span>Following:</span>
									</div>
									<div class="user-info-card__stats--numbers">
										<span>8</span>
									</div>
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
					<div class="fixme-rite-sec">
						<div class="main-page__cmmn-card">
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
			  <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
					<form action="#" class="needs-validation" novalidate>
						<div class="form-group">
							<div class="to-cmbine-the-label-txt">
								<label for="uname">Title</label>
								<input type="text" class="form-control" id="uname" placeholder="UX/UI Designer" name="uname" required>
							</div>						 
						  <div class="valid-feedback">Valid.</div>
						  <div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
						  <div class="to-cmbine-the-label-txt">
							  <label for="desc">Describe:</label>
							  <textarea rows="4" cols="50" name="comment" 
							  form="usrform" class="form-control" id="pwd" name="desc" placeholder="The UX/UI Designers will be responsible for collecting, researching, investigating and evaluating user requirements. Their responsibility is to deliver an outstanding user experience providing an exceptional and intuitive application design." required>
								</textarea>		
						  </div> 
						  <div class="valid-feedback">Valid.</div>
						  <div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group form-check">
						</div>
						<div class="main-page__form-buttons">
							<button type="submit" class="btn btn-primary">Save for later</button>
							<button type="submit" class="btn btn-primary">Continue</button>
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
				  <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
						<form id="acknowledgeForm" method="post"  action="{{ route('acknowledge') }}" class="needs-validation" novalidate>
							<div class="form-group">
								<div class="to-cmbine-the-label-txt">
									<label for="uname">Who do you want to recognize?</label>
									<!--input type="text" class="form-control" id="uname" placeholder="Sonny Fernandez" name="uname" required>-->
									<select class="js-example-basic-multiple form-control" name="user_id"  id="user_id">
											<option value="">-- Choose --</option>
											@foreach ($all_users as $urow)
											<option value="{{ $urow->id }}" {{ ($urow->id==old('user_id')) ? "selected" : "" }}>{{ $urow->mname }}</option>
											@endforeach 							  
									</select>
								</div>						 
							  <div class="valid-feedback">Valid.</div>
							  <div class="invalid-feedback"  id="error-user_id"></div>
							</div>
							<div class="form-group">
							  <div class="to-cmbine-the-label-txt">
								  <label for="desc">Tell us why?</label>
								  <textarea placeholder="Sonny provided a lot of great design workand worked well with others. He can fit into any team environment with ease and provide extraordinary results very quickly!" rows="4" cols="50" name="message" class="form-control" id="message" required></textarea>		
							  </div> 
							  <div class="valid-feedback">Valid.</div>
							  <div class="invalid-feedback" id="error-message"></div>
							</div>
							<div class="form-group form-check">
							</div>
							<div class="main-page__form-buttons">
								<button type="submit" class="btn btn-primary">Acknowledge</button>
							</div>
						  </form>
					</div>
				</div>	
		  </div>
		</div>
	  </div>
	  
<script src="{{ URL::asset('js/jm.spinner.js') }}"></script>
<script type="text/javascript">
var hasData = true;
var isLoading = false;	

$('#message').on('keyup',function() {
	$('#error-message').hide();
});
$('#user_id').on('change',function() {
	$('#error-user_id').hide();
});

$("#acknowledgeForm").submit(function(e) {
	e.preventDefault(); // avoid to execute the actual submit of the form.
	var form = $(this);

	$.ajax({
		type: "POST",
		url: SITE_URL+"/acknowledge",
		data: form.serializeArray(), // serializes the form's elements.
		beforeSend: function(){
		},error: function(){
			alert('ACK ajax error!')
		},success: function(){
			$('.invalid-feedback').hide()
		},complete: function( data ){
			var obj = $.parseJSON( data.responseText ); 
			if(obj.type=='success'){ //console.log(obj)
				//$('#mainPage__acknowledgeAnExpert .modal-content').html(obj.success_html);
				$('#acknowledge').addClass('hidden');
				$('#thanks_up').html(obj.success_html);
				$('#thanks_up').removeClass('hidden');
				setTimeout(function(){ 
					 $('#mainPage__acknowledgeAnExpert').modal('toggle')
				}, 2000);
			}else{
				jQuery.each(obj.keys, function(key, value){
					var error_msg = obj.errors[key] //console.log("#"+value)
					var error_elem =  $("#"+value).closest(".form-group").find(".invalid-feedback");
					error_elem.show()
					error_elem.text(error_msg);
				});
			}
		}, 
	});


});

function sortWidget(slug,sortby){
	$.ajax({
		type: "POST",
		url: SITE_URL+"/sort-widget",
		data: {slug: slug, sortby: sortby}, 
		beforeSend: function(){
		},error: function(){
			alert('SORT ajax error!')
		},success: function(){
		},complete: function( data ){
			var obj = $.parseJSON( data.responseText ); 
			if(obj.type=='success'){ //console.log(obj)
				$('#'+slug).html(obj.success_html);
				
			}else{
			}
		}, 
	})
}

$(document).ready(function() {

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
					if(obj.feed == true) {
						$('#home-feed').append(obj.html);
						var cur_page = $('#cur_page').val(page_no); 
						hasData=true;
					} else {
						if(!$('#caught_up').length){
							//$('#home-feed').append('<div id="caught_up" class="col-md-12 text-center">You\'re All Caught Up</div>');
						}
						hasData=false;		
					}
					isLoading = false;
					$('.box').jmspinner(false);
            },
        });
    }

   	$(window).on('scroll', function() {
		if(Math.ceil($(window).scrollTop()) + Math.ceil($(window).height()) >= Math.ceil($(document).height())) {
			if(hasData==true && isLoading==false) {
				$('.box').jmspinner('small');
				var cur_page = $('#cur_page').val(); 
				var total_page = $('#total_page').val(); //console.log('cur_page'+cur_page) ;  console.log('total_page'+total_page);
				setTimeout(function(){
					console.log(cur_page);
					var page_no = parseInt(cur_page)+1;
					if(cur_page != page_no) {
						load_feed_data(page_no, total_page);
					}	
				}, 500);	
			}	
		}
	});
	
	
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

	$(document).on('click', '#acknowledgeAnExpert', function() {
		$('#acknowledge').removeClass('hidden');
		$('#thanks_up').addClass('hidden');
		$('#error-message').hide();
		$('#error-user_id').hide();
		$('#user_id').val('');
		$('#message').val('');
		$('#mainPage__acknowledgeAnExpert').modal('show');
	});

	function remove_feed(feed_id){
		$.ajax({
            url: "{{ route('feed-action') }}",
            type: "POST",
            data: {
			'feed_id': feed_id,
			'action': 'remove_feed'
            },
            beforeSend: function() {
            },
            error: function() {
            },
            success: function() {
            },
            complete: function(data) {
                var obj = $.parseJSON(data.responseText); //console.log(obj)
			if(obj.type='success'){
				$('#parent-'+feed_id).html(obj.feed_html);
			}
               //$('#home-feed').append(obj.html);
            },
        });
	}
});
</script>
@endsection

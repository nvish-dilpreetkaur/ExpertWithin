@extends('layouts.app')
@section('content')   

<!-- filters html -->
@include('common.top-nav')
@include('home.filters-section')
<!-- filters html -->

<div id="pageBodyWrapCls">
	<!-- Details start -->
	<section class="section-details" >
	<div class="jumbotron jumbotron-fluid header-section-details">
		<div class="container">
			<div class="row">
				<div class="col-lg-9">
					<div class="block-left">
					<div class="card-title-area">
						<img src="{{ URL::asset('images/open-book-yellow.svg') }}" class="card-book-pic">
						<div class="">
							@foreach($opp_focus_list as $focRow)
								{{ $loop->first ? '' : ', ' }}
								{{$focRow->name }}
							@endforeach
						</div>
					</div>
					<p class="">{{ $opportunity_data->opportunity }}</p>
					</div>
				</div>
				<div class="col-lg-3">
						<div class="block-right">
							<div class="btn-group-action" id="detailActWrapper" data-likeurl="{{ url('opportunity/like', Crypt::encrypt($opportunity_data->id)) }}" data-unlikeurl="{{ url('opportunity/not_like', Crypt::encrypt($opportunity_data->id)) }}" data-likeimgurl="{{ URL::asset('images/thumbs-up-r.svg') }}" data-unlikeimgurl="{{ URL::asset('images/thumbs-up.svg') }}" data-favurl="{{ url('opportunity/favourite', Crypt::encrypt($opportunity_data->id)) }}" data-unfavurl="{{ url('opportunity/not_favourite', Crypt::encrypt($opportunity_data->id)) }}" data-favimgurl="{{ URL::asset('images/heart-fill.svg') }}" data-unfavimgurl="{{ URL::asset('images/heart-outline.svg') }}">
								<!-- mark like -->
								@if(!$loggedInUserID)
									<a class="" href="{{ ($loggedInUserID) ? '' : route('login') }}">
										<img src="{{ URL::asset('images/thumbs-up.svg') }}"><p>Like</p></a>
								@elseif($opportunity_data->like == 0)
									<a  href="javascript:void(0)"  class="likeBtn{{$opportunity_data->id}}" data-action="like"  data-page="OPD">
									<img src="{{ URL::asset('images/thumbs-up.svg') }}"><p>Like</p>
									</a>
								@else
								<a  href="javascript:void(0)"  class="likeBtn{{$opportunity_data->id}}" data-action="unlike" data-page="OPD">
										<img src="{{ URL::asset('images/thumbs-up-r.svg') }}"><p>Like</p>
									</a>
								@endif
								<!-- mark fav -->
								@if(!$loggedInUserID)
									<a class="" href="{{ ($loggedInUserID) ? '' : route('login') }}"><img src="{{ URL::asset('images/heart-outline.svg') }}"><p>Favorite</p></a>
								@elseif($opportunity_data->favourite == 0)
								<a  href="javascript:void(0)"  class="favBtn{{$opportunity_data->id}}" data-action="fav"  data-page="OPD">
								<img src="{{ URL::asset('images/heart-outline.svg') }}" ><p>Favorite</p>
								</a>
								@else
								<a   href="javascript:void(0)"  class="favBtn{{$opportunity_data->id}}" data-action="unfav"  data-page="OPD">
								<img src="{{ URL::asset('images/heart-fill.svg') }}"><p>Favorite</p>
								</a>
					@endif
							</div>
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bottom-section-details fixed-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-9">
					<div class="block-left"> 
						<p class="">{{ $opportunity_data->opportunity }}</p>
						<p class="">{{ $opportunity_data->opportunity_desc }}</p>
					</div>
				</div>
				<div class="col-lg-3">
						<div class="block-right">
						@if($loggedInUserID != $opportunity_data->org_uid)
							@if(!$loggedInUserID)
								<a href="{{ ($loggedInUserID) ? '' : route('login') }}" class="common-card-apply-btn">Apply</a>
							@elseif($opportunity_data->apply == 0)
								<a class="applyBtn{{$opportunity_data->id}} common-card-apply-btn"  data-oid="{{$opportunity_data->id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($opportunity_data->id)) }}">Apply</a>
							@else
								<a class="applyBtn{{$opportunity_data->id}} common-card-apply-btn appliedOpp{{$opportunity_data->id}}" href="javascript:void(0)">{{ __('Applied') }}</a>
							@endif
						@endif
						</div>
				</div>
			</div>
		</div>
	</div>
	@php $showApplicantTab = false  @endphp
	@if( (in_array(config('kloves.ROLE_MANAGER'),explode(",",Auth::user()->roles))  && Auth::user()->id== $opportunity_data->org_uid ) || ($opportunity_data->apply==1) )
		@php $showApplicantTab = true  @endphp
	@endif
	<div class="tab-nav-cont">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Details</a>
						</li>
						@if($showApplicantTab)
						<li class="nav-item">
							<a class="nav-link" id="applicants-tab" data-toggle="tab" href="#applicants" data-href="{{ url('opp-applicants', Crypt::encrypt($opportunity_data->id)) }}" role="tab" aria-controls="applicants" aria-selected="false">Applicants</a>
						</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-content-cont">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="tab-content">
						<div class="tab-pane active" id="details" role="tabpanel" aria-labelledby="details-tab">
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-9">
										<h3>Opportunity summary</h3>
										<p>{{ $opportunity_data->opportunity_description }}</p>

										<!--<h3>Make a difference- incentive</h3>
										<p>Klove research is developing a proof-of-concept prototype and will evaluate end-to-end system performance. Gain industry skill in this project.</p>-->

										<h3>Reward</h3>
										<p>{{ $opportunity_data->rewards }}</p>
										<div class="skills-cont">
											<h3>Skills</h3>
											<p>
												@foreach($opp_skill_list as $oppSkill)
													<span class="badge-light">{{ $oppSkill->name }}</span>
												@endforeach
											</p>
										</div>

										<div class="comment-cont">
											<h3>Comment opportunity</h3>
											<form class="public-comment-form" method="POST" action="{{ url('post-opp-comment') }}">
												<div class="form-group clearfix">
												<textarea class="form-control char-limit" id="commentTextarea" placeholder="" name="comment_content" data-char-limit="500" required></textarea>
												<div class="char-limit-text"></div>
												</div>
												@csrf
												<input type="hidden" name="oid" value="{{  Crypt::encrypt($opportunity_data->id) }}">
												<input type="hidden" name="to_id" value="{{  Crypt::encrypt($opportunity_data->org_uid) }}">
												<input type="hidden" name="from_id" value="{{  Crypt::encrypt(Auth::user()->id) }}">
												<input type="hidden" name="comment_type" value="2">
												<button class="btn btn-light" type="submit">Post</button>
											</form>
										</div>
										<div class="public-comment-section">
											@include('opportunity.comment_listing')
										</div>
									</div>
									<div class="col-lg-3">
										<ul class="timeline-opportunity">
											<li>
												<h3>Apply Before:</h3>
												<p>{{ date('m-d-y', strtotime($opportunity_data->apply_before)) }}</p>
											</li>
											<li>
												<h3>Start:</h3>
												<p>{{ date('m-d-y', strtotime($opportunity_data->start_date)) }}</p>
											</li>
											<li>
												<h3>End:</h3>
												<p>{{ date('m-d-y', strtotime($opportunity_data->end_date)) }}</p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						@if($showApplicantTab)
						<div class="tab-pane" id="applicants" role="tabpanel" aria-labelledby="applicants-tab">
							@include('opportunity.oppo_applicant_list')
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
	<!-- Details end -->
	<!-------YOU MAY ALSO LIKE SECTION START---------------------->
	<div class="recently-viewed-section-outer">
			@include('opportunity.you-may-like')
		</div>
	<!-------YOU MAY ALSO LIKE SECTION START---------------------->
</div>
<script type="text/javascript">
	$(document).ready(function () {
		//$("#ajaxsuccess .ajaxsuccess-modal .modal-body .success-text").text('message');
		//$('#ajaxsuccess').modal({show:true});
		/** apply code : starts **/
			$(document).on('click',"a[class^='applyBtn']",function(e){ 
			e.stopPropagation();
			var oppID = $(this).data('oid'); 
			var elem = $(this); 
			var url = $(this).attr('data-href');
			performOpportunityAction(elem, url, oppID);
		})
		/** applyBtn code : ends **/
		
		/** like/dislike code : starts **/
		$(document).on('click',"a[class^='likeBtn']",function(e){ 
			e.stopPropagation();
			var eventClass = $(this).attr('class');
			var elem = $(this);
			var url = $(this).attr('data-href');
			performOpportunityAction(elem, url, eventClass);
		})
		/** like/dislike code : ends **/
		
		/** fav/unfav code : starts **/
		$(document).on('click',"a[class^='favBtn']",function(e){
			e.stopPropagation();
			var eventClass = $(this).attr('class');
			var elem = $(this);
			var url = $(this).attr('data-href');
			performOpportunityAction(elem, url, eventClass);
		})
		/** fav/unfav code : ends **/
		
		/** fav/unfav code : starts **/
		$(document).on('click',".commentApplicant", function(e){  
			$(this).closest('li').addClass('showCommentArea');
		});

		$(document).on("click", function (e) { 
            //e.stopPropagation();
            if (!$(e.target).is(".opp-comment-form, .opp-comment-form *, .commentApplicant")) {
                if ($(".opp-comment-form").closest('li').hasClass("showCommentArea")) {
                    $(".opp-comment-form").closest('li').removeClass('showCommentArea');
                }
		}
        });
		/** fav/unfav code : ends **/

		/** get applicant list code : starts **/
		/*$(document).on('click',"#applicants-tab", function(e){
			var url = $(this).data('href');
			getOppApplicantList(url)
		}); */
		/** get applicant list code : ends **/

		/** perform manager action : starts **/
		$(document).on('click',".actionMBtn", function(e){ 
			var elem = $(this);
			var action = elem.data('action');
			if (confirm('Are you sure to '+action+' ?')) {
				performOpportunityManagerAction(elem)
			}else{
				//do nothing
			}
			
		});
		/** perform manager action : ends **/

		/** log comment action : starts **/
		$(document).on('submit',".user-comment-form", function(e){
			e.preventDefault();
			postComment($(this))
			
		});
		/** log comment action : ends **/

		/** get latest comments : starts **/
		$(document).on('click',".commentApplicant", function(e){
			var elem = $(this);
			refreshPrivateComments(elem)
		});
		/** get latest comments : ends **/

		
		/** log public comment action  : starts **/
		$(document).on('keypress paste',"#commentTextarea", function(e){ 
			$('.invalid-feedback').remove();	
		})
		$(document).on('submit',".public-comment-form", function(e){
			e.preventDefault();
			if ($.trim($('#commentTextarea').val()) == ""){
				if($('.invalid-feedback :visible').length == 0){
					$('#commentTextarea').after('<span class="invalid-feedback" role="alert"> <strong>Enter your comments.</strong></span>');	
					$('.invalid-feedback').show();
					$('.char-limit-text').html('');
					$('#commentTextarea').val('');
				}
				return false;
			}else{
				$('.invalid-feedback').remove();	
			}
			postComment($(this),'PUBLIC_COMMENT')
		});
		/** log public comment action : ends **/
		
	});
	
	function postComment(elem,slug){
		$.ajax({
			url: SITE_URL+'/post-opp-comment',
			type: "POST",
			data:{ "formData" : elem.serialize() , "_token": "{{ csrf_token() }}",},
			dataType: 'JSON',
			beforeSend: function(){
				
			},error: function(){
				alert('Post comment fetch ajax error!')
			},success: function(){
				
			},complete: function( data ){
				var obj = $.parseJSON( data.responseText ); 
				if(obj.status=='1'){
					//$("#ajaxsuccess .success-modal .modal-body .success-text").text(obj.message);
					//$('#ajaxsuccess').modal({show:true});
					if(obj.type=='1'){
						//var refreshUrl = $('#applicants-tab').data('href');
						//getOppApplicantList(refreshUrl)
						$('.comment_content').val('');
						refreshPrivateComments(elem)
					}else if(obj.type=='2'){
						$('#commentTextarea').val('');
						$('.char-limit-text').html('');
						refreshPublicComments()
					}
				}else{
				
				}
			}
		});
		
		return false
	}


	function refreshPublicComments(){
		var id = $("input[name='oid']").val();
		$.ajax({
			url: SITE_URL+'/opp-comment-list/'+id,
			type: "GET",
			dataType: 'JSON',
			beforeSend: function(){
				
			},error: function(){
				alert('Applicant fetch ajax error!')
			},success: function(){
				
			},complete: function( data ){
				var obj = $.parseJSON( data.responseText ); 
				if(obj.type=='success'){
					$('.public-comment-section').html(obj.html);
				}else{
					//console.log( 'error in getting applicant tab' );
				}
			},
		});
	}

	function performOpportunityManagerAction(elem){
		var href = elem.data('href');
		var action = elem.data('action');
		var id = elem.data('oppid');
		var applicant_id = elem.data('applicant_id');
		$.ajax({
			url: href,
			type: "POST",
			data:{
				"action_type": 'APPLY',
				"action": action,
				"applicant_id": applicant_id,
				"id": id,
				"_token": "{{ csrf_token() }}",
				},
			dataType: 'JSON',
			beforeSend: function(){
				var action = elem.data('action')
				if(action == 'approve' || action=='reject'){
					var btnHTML = elem.html()
					elem.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Processing')	
				}
			},error: function(){
				alert('Applicant fetch ajax error!')
			},success: function(){
				
			},complete: function( data ){
				var obj = $.parseJSON( data.responseText ); 
				if(obj.status=='1'){
					//$("#success .success-modal .modal-body .success-text").text(obj.message);
				//	$('#success').modal({show:true});
					var refreshUrl = SITE_URL +'/opp-applicants/'+id;
					getOppApplicantList(refreshUrl)
				}else{
				
				}
			},
		});
	}

	function getOppApplicantList(url){
		$.ajax({
			url: url,
			type: "GET",
			data:{},
			dataType: 'JSON',
			beforeSend: function(){
				
			},error: function(){
				alert('Applicant fetch ajax error!')
			},success: function(){
				
			},complete: function( data ){
				var obj = $.parseJSON( data.responseText ); 
				if(obj.type=='success'){
					$('#applicants').html(obj.html);
				}else{
					console.log( 'error in getting applicant tab' );
				}
			},
		});
	}

	
	function performOpportunityAction(elem, url, oppID){ 
		$.ajax({
			url: url,
			type: "GET",
			data:{},
			dataType: 'JSON',
			beforeSend: function(){
				
			},error: function(){
				
			},success: function(){
				
			},complete: function( data ){
				var obj = $.parseJSON( data.responseText ); //console.log( data.responseText );
				if(obj.status==1){
					if(obj.action=='LIKE'){
						var liked_img_url = $('.'+oppID).attr('data-likedImgURL');	
						$('.'+oppID).html('<img src="'+liked_img_url+'"><p>Like</p>');
					}else if(obj.action=='FAVOURITE'){ 
						var fav_img_url = $('.'+oppID).attr('data-favImgURL');	
						$('.'+oppID).html('<img src="'+fav_img_url+'"><p>Favorite</p>');
					}else if(obj.action=='APPLY'){
						$('a[class^="applyBtn"]').each(function( index ) {
							if($(this).data("oid") == oppID){
								$(this).html('Applied');
								$(this).addClass('appliedOpp'+oppID);
							}
						})
					$("#success .success-modal .modal-body .success-text").text(obj.successMessage);
					$('#success').modal({show:true});
					}
				}
			},
		});
	}


	function refreshPrivateComments(elem){ 
		var oid = $(elem).data('oppid'); 
		var applicant_id = $(elem).data('applicant_id'); 
		$.ajax({
			url: SITE_URL+'/opp-user-conversation/',
			type: "GET",
			dataType: 'JSON',
			data:{
				oid : oid,
				applicant_id : applicant_id
			},
			beforeSend: function(){
				
			},error: function(){
				alert('Applicant fetch ajax error!')
			},success: function(){
				
			},complete: function( data ){
				var obj = $.parseJSON( data.responseText ); 
				if(obj.type=='success'){
					var target = $(elem).data('target');
					$('.'+target).html(obj.html);
				}else{
					//console.log( 'error in getting applicant tab' );
				}
			},
		});
	}
</script>
@endsection
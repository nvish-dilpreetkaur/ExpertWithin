@extends('layouts.app')
@section('content')   
<div class="container">
	<div class="row clearfix">
	   <div class="main-contnt-body">
		   <div class="opportunity-details__wrapper">
		<div class="row">
		  
		   <!--LEFT-SECTION-->
		   <div class="col-md-8 col-lg-8 opportunity-detail__left-section--outer">
			<div class="main-page__cmmn-card opportunity-detail-page__card">
			   <div class="opportunity-detail-page__card--top-bottom">
				   <div class="row clearfix">
					   @if(!empty($opportunity_data->image_name))
						<div class="col-md-1">
						 <img src="{{$opportunity_data->image_name}}" style="width: 100%;">
					   </div>
					   @else
						<div class="col-md-1">
						 <i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
					   </div>
					   @endif
					   <div class="col-md-2 for-null-paddng">
						<div class="main-page-cmmn-feed-card__footer-area--desg">{{ $opportunity_data->uname }}</div>
						<div class="main-page-cmmn-feed-card__footer-area--dept">{{ $opportunity_data->department }}</div>
					   </div>
					   <div class="col-md-4 for-null-paddng">
						<div class="opportunity-detail-page__card--social-icons">
							@if($opportunity_data->like == 1)
								<a href="javascript:void(0)" class="likeOppBtn{{$opportunity_data->opp_id}}" data-action="unlike"  data-oid="{{$opportunity_data->opp_id}}"><i class="fas fa-thumbs-up"></i></a>
							@else
								 <a href="javascript:void(0)" class="likeOppBtn{{$opportunity_data->opp_id}}" data-action="like"  data-oid="{{$opportunity_data->opp_id}}"><i class="far fa-thumbs-up"></i></a>
							@endif

							@if($opportunity_data->favourite == 1)
								<a href="javascript:void(0)" class="favOppBtn{{$opportunity_data->opp_id}}" data-action="unfav"  data-oid="{{$opportunity_data->opp_id}}"><i class="fas fa-heart"></i></a>
							@else
								<a href="javascript:void(0)" class="favOppBtn{{$opportunity_data->opp_id}}" data-action="fav"  data-oid="{{$opportunity_data->opp_id}}"> <i class="far fa-heart"></i></a>
							@endif
						 
						   <i class="far fa-comment" aria-hidden="true"></i>
						   <i class="far fa-share-square" aria-hidden="true"></i>
						</div>
					   </div>
					   <div class="col-md-5">
						<div class="opportunity-detail-page__card--apply-btn">
							@if(Auth::user()->id !=  $opportunity_data->org_uid) 
								@if($opportunity_data->apply == 0)
									<a class="applyBtn{{$opportunity_data->opp_id}}"  data-oid="{{$opportunity_data->opp_id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($opportunity_data->opp_id)) }}">Apply</a>
								@else
									<a class="appliedOpp{{$opportunity_data->opp_id}}" href="javascript:void(0)">{{ __('Applied') }}</a>
								@endif
							@endif	
						</div>
					   </div>
					</div>
			   </div>

			   
			   <div class="opportunity-detail-page__card--content">
				<div class="row clearfix">
				   <div class="col-md-6">
					   <div class="opportunity-detail-page__card--content__left-section">
						<div class="oppor-create-card__heading">
							{{ $opportunity_data->opportunity }}
						</div>   
						<div class="oppor-create-card__left-content">
						   <span>Est start <span class="for-fnt-weight">{{ date("d M, Y",strtotime($opportunity_data->start_date)) }}</span>  |  Est end <span class="for-fnt-weight">{{ date("d M, Y",strtotime($opportunity_data->end_date)) }}</span></span>
						   <div class="oppor-create-card__content-rewards">
						    <span><span class="for-fnt-weight"> Rewards</span> <span> {{ $opportunity_data->rewards }}</span> </span> 
						     <i class="fas fa-coins gold-coins-color" aria-hidden="true"><span>{{ $opportunity_data->tokens }}</span></i>
						   </div>
						   <div class="oppor-create-card__content-summary">
							<div class="oppor-create-card__content--cmmn-heading">Summary</div>
							<p>{{ $opportunity_data->opportunity_desc }}</p>
						   </div>
						   <div class="oppor-create-card__content--cmmn-heading">What are the incentives?</div>
						   <p>{{ $opportunity_data->incentives }}</p>
						</div>                                        
					   </div>                                      
				   </div>
				   <div class="col-md-6">
					   <div class="opportunity-detail-page__card--content__right-section">
						   <div class="oppor-create-card__heading red-colr-txt">
							   Last day to apply: {{ ($opportunity_data->apply_before) ? date("d M, Y",strtotime($opportunity_data->apply_before)) : '-'}}
						   </div>
						   <div class="oppor-create-card__content--cmmn-heading">Skills</div>
						   <div class="cmmn__pills">
							<ul>
								@foreach($opportunity_data->skills as  $skillrow)
									<li><a href="javascript:void(0)">{{ $skillrow->name }}</a></li>
								@endforeach
							</ul>
						   </div>

						   <div class="oppor-create-card__content--cmmn-heading">Focus areas</div>
						   <div class="cmmn__pills">
							<ul>
								@foreach($opportunity_data->focus as  $focusrow)
									<li><a href="javascript:void(0)">{{ $focusrow->name }}</a></li>
								@endforeach
							</ul>
						   </div>
					   </div>                                      
				   </div> 
				</div>
			   </div>
			   <div class="opportunity-detail-page__card--top-bottom">
				   <div class="row clearfix">                                        
					   <div class="col-md-12">
						<div class="opportunity-detail-page__card--apply-btn">
						@if(Auth::user()->id !=  $opportunity_data->org_uid) 
							@if($opportunity_data->apply == 0)
								<a class="applyBtn{{$opportunity_data->opp_id}} common-card-apply-btn"  data-oid="{{$opportunity_data->opp_id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($opportunity_data->opp_id)) }}">Apply</a>
							@else
								<a class="applyBtn{{$opportunity_data->opp_id}} common-card-apply-btn appliedOpp{{$opportunity_data->opp_id}}" href="javascript:void(0)">{{ __('Applied') }}</a>
							@endif
						@endif	
						</div>
					   </div>
					</div>
			   </div>

			</div>
					<!------->

				</div>
		   <!--MIDDLE-SCROLL-SECTION-->
		   <div class="col-md-4 col-lg-4 opportunity-detail__righ-section--outer">
			<p>You may also like</p>
			<div class="middle-scroll-section__outer">
				@include('opportunity.you-may-like-section')
			</div>
			@if ($youMayLikeOpp != null)
			<div class="col-md-12">
			<div class="main-page__cmmn-card--footer">
				<p class="show-more">Show More</p>
			</div>
			</div>
			@endif
		</div>
		   <!--RIGHT-SECTION-->
		</div>
		</div><!-----opportunity-details__wrapper-END-->
	   </div>
	</div>
</div>
<script type="text/javascript">
/** like/dislike opportunity code : starts **/
	$(document).on('click',"a[class^='likeOppBtn']",function(e){
		e.stopPropagation();
		var action = $(this).attr('data-action')
		var oid = $(this).attr('data-oid')
		var elem = $(this)
		
		var pdata = { 'action' : action, 'oid': oid };
		//console.log(url)
		performOppAction(elem,pdata);
	}); 
/** like/dislike opportunity code : ends **/

/** fav/unfav opportunity code : starts **/
	$(document).on('click',"a[class^='favOppBtn']",function(e){
		e.stopPropagation();
		var action = $(this).attr('data-action')
		var oid = $(this).attr('data-oid')
		var elem = $(this)
		
		var pdata = { 'action' : action, 'oid': oid };
		//console.log(url)
		performOppAction(elem,pdata);
	}); 
/** fav/unfav opportunity code : ends **/
/** apply code : starts **/
	$(document).on('click',"a[class^='applyBtn']",function(e){ 
		e.stopPropagation();
		var oppID = $(this).data('oid'); 
		var elem = $(this); 
		var url = $(this).attr('data-href');
		performOpportunityAction(elem, url, oppID);
	})
/** applyBtn code : ends **/
function performOpportunityAction(elem, url, oppID){
	$.ajax({
		url: url,
		type: "GET",
		data:{},
		dataType: 'JSON',
		beforeSend: function(){
			var btnHtml = elem.html()
			if(btnHtml=='Apply'){
				elem.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Processing')
			}
		},error: function(){
			
		},success: function(){
			
		},complete: function( data ){
			var obj = JSON.parse( data.responseText );  console.log(obj);
			if(obj.status==1){
				if(obj.action=='APPLY'){
					$('a[class^="applyBtn"]').each(function( index ) {
						if($(this).data("oid") == oppID){
							$(this).html('Applied');
							$(this).removeClass();
							$(this).addClass('appliedOpp'+oppID);
							
						}
					})
				}
				$('#thumbUpModel').modal('show');
				$('#success_message_thumbupWrapper').html(obj.success_html);
				/*setTimeout(function(){ 
					 $('#thumbUpModel').modal('toggle')
				}, 2000);*/
			}
		},
	});
}
	function performOppAction(elem,pdata){
		$.ajax({
			url: SITE_URL+'/opportunity-action',
			type: "POST",
			data:pdata,
			dataType: 'JSON',
			beforeSend: function(){

			},error: function(){
				
			},success: function(){
				
			},complete: function( data ){
				var obj = JSON.parse( data.responseText ); 
				if(obj.type=='success'){
					if(obj.action=='like'){
						elem.html('<i class="fas fa-thumbs-up"></i>');
						elem.attr('data-action','unlike')
					}else if(obj.action=='unlike'){
						elem.html('<i class="far fa-thumbs-up"></i>');
						elem.attr('data-action','like')
					}else if(obj.action=='fav'){
						elem.html('<i class="fas fa-heart"></i>');
						elem.attr('data-action','unfav')
					}else if(obj.action=='unfav'){
						elem.html('<i class="far fa-heart"></i>');
						elem.attr('data-action','fav')
					}
				}
			},
		});
	}
	/** REMOVE FEED : STARTS **/
	$(document).on('click', '.remove_feed_link', function() {
		var feed_id = $(this).data('id'); 
		remove_feed(feed_id);
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
	/** REMOVE FEED : ENDS **/
</script>
@endsection


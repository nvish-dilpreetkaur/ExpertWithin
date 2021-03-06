@extends('layouts.app')
@section('content')   
<div class="container">
	<div class="row clearfix">
	   <div class="main-contnt-body">
		   <div class="opportunity-details__wrapper">
		<div class="row">
		  
		   <!--LEFT-SECTION-->
		   <div class="col-md-8 col-lg-8 opportunity-detail__left-section--outer">

		   <div class="opportunity-detail-published__top-section">
                           <a href="{{ route('list-opportunity') }}">
                           <div class="cmmn-button__black-bg ripple-effect">
                                <i class="fas fa-door-open" aria-hidden="true"></i>
                              <span>View my opportunities for candidates</span>
                           </div>
                           </a>

                           <div class="common-icons__paginations">
                                <a href="{{ (!empty($prevOpportunity))?url('view-opportunity', $prevOpportunity):'' }}" class="common-icons__paginations--for-left-pagination ripple-effect {{(empty($prevOpportunity))?'disabled':''}}"><i class="fas fa-chevron-left"></i></a>
                                <a href="{{ (!empty($nextOpportunity))?url('view-opportunity', $nextOpportunity):'' }}" class="common-icons__paginations--for-right-pagination ripple-effect {{(empty($nextOpportunity))?'disabled':''}}"><i class="fas fa-chevron-right"></i></a>
                           </div>
                        </div>



			<div class="main-page__cmmn-card opportunity-detail-page__card">
			   <div class="opportunity-detail-page__card--top-bottom">
				   <div class="row clearfix">
					   @if(!empty($opportunity_data->image_name))
						<div class="col-md-1 for-common-linked-text__style">
							<a href="{{ url('profile', Crypt::encrypt($opportunity_data->org_uid)) }}"><div class="publish-page-cmn-card__user-pic" style="background: url('{{$opportunity_data->image_name}}') ;"></div></a>
					   </div>
					   @else
						<div class="col-md-1 for-common-linked-text__style">
						<a href="{{ url('profile', Crypt::encrypt($opportunity_data->org_uid)) }}"><i class="fas fa-user-circle fa-2x" aria-hidden="true"></i></a>
					   </div>
					   @endif
					   <div class="col-md-2 for-null-paddng">
						<div class="main-page-cmmn-feed-card__footer-area--desg for-common-linked-text__style">
						<a href="{{ url('profile', Crypt::encrypt($opportunity_data->org_uid)) }}">{{ $opportunity_data->uname }}</a>
						</div>
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
						   <a href="#mainPage__sharetoExpert" class="shareBtn{{$opportunity_data->opp_id}}" data-remote="{{ url('share-feed', Crypt::encrypt($opportunity_data->opp_id)) }}" data-toggle="modal" data-target="#mainPage__sharetoExpert" data-share_type="OPP"><i class="far fa-share-square"></i></a> 
						</div>
					   </div>
					   <div class="col-md-5">
						<div class="opportunity-detail-page__card--apply-btn">
							@if(Auth::user()->id != $opportunity_data->org_uid && empty($opportunity_data->job_start_date) && empty($opportunity_data->job_complete_date)) 
								@if(($opportunity_data->apply == config('kloves.FLAG_SET'))  && ($opportunity_data->approve == config('kloves.OPP_APPLY_NEW') || $opportunity_data->approve == config('kloves.OPP_APPLY_APPROVED')) )
									<a class="withdrawBtn{{$opportunity_data->opp_id}}" data-oid="{{$opportunity_data->opp_id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($opportunity_data->opp_id)) }}">{{ __('Withdraw') }}</a>
								@else
									<a class="applyBtn{{$opportunity_data->opp_id}}"  data-oid="{{$opportunity_data->opp_id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($opportunity_data->opp_id)) }}">Apply</a>
								@endif
							@endif	
						</div>
					   </div>
					</div>
			   </div>

			   <div class="common-black-strip-for-status-message applyStatusStrip">
				<?=getOppApplyStatus($opportunity_data->apply, $opportunity_data->approve,  $opportunity_data->status, $opportunity_data->job_complete_date, $opportunity_data->apply_before);?>
				</div>
			   
			   <div class="opportunity-detail-page__card--content">
				<div class="row clearfix">
				   <div class="col-md-7">
					   <div class="opportunity-detail-page__card--content__left-section">
						<div class="oppor-create-card__heading common-opportunity-heading__inner-page">
							{{ $opportunity_data->opportunity }}
						</div>   

						<div class="oppor-create-card__left-content oppor-published-card__common-list-details">
								<ul>
								<li><span class="for-fnt-weight">Start: {{ date("d M, Y",strtotime($opportunity_data->start_date)) }}</span></li>
								<li><span class="for-fnt-weight">End: {{ date("d M, Y",strtotime($opportunity_data->end_date)) }}</span></li>
								<li ><span class="for-fnt-weight">Apply by: {{ date("d M, Y",strtotime($opportunity_data->apply_before)) }}</span></li>
								<br/>
								<li style="display:none;">Allocated <span class="for-fnt-weight">15hrs</span></li>
								<li><span class="for-fnt-weight">{{$opportunity_data->expert_hrs}}hrs/wk</span></li>
								<li><span class="for-fnt-weight">{{$opportunity_data->approved_experts}}</span> of <span class="for-fnt-weight">{{$opportunity_data->expert_qty}}</span> candidate(s)</li>							
								</ul>
						</div>



						<!-- <div class="oppor-create-card__left-content">							
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
						</div>-->


						<div class="oppor-create-card__content-summary">
								<div class="oppor-create-card__content--cmmn-heading">Summary</div>
								<p>{{ $opportunity_data->opportunity_desc }}</p>
													

								<div class="oppor-create-card__content--cmmn-heading">What are the incentives?</div>
								<p>{{ $opportunity_data->incentives }}</p>

								<div class="oppor-create-card__content--cmmn-heading">Reward</div>
								<p>{{ $opportunity_data->rewards }}</p>
								<p><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="for-fnt-weight">{{ $opportunity_data->tokens }}</span></p>
                                   
                         </div>


					   </div>                                      
				   </div>
				 
				   <div class="col-md-5">
					   <div class="opportunity-detail-page__card--content__right-section">
					  		 <div class="common-opportunity-heading__inner-page common-opportunity-heading-small__inner-page">
                                                Skills
                            </div>
						   <!-- <div class="oppor-create-card__heading red-colr-txt">
							   Last day to apply: {{ ($opportunity_data->apply_before) ? date("d M, Y",strtotime($opportunity_data->apply_before)) : '-'}}
						   </div> -->
						   <!-- <div class="oppor-create-card__content--cmmn-heading">Skills</div> -->
						   <div class="cmmn__pills common_pills__black-border">
							<ul>
								@foreach($opportunity_data->skills as  $skillrow)
									<li><a href="javascript:void(0)">{{ $skillrow->name }}</a></li>
								@endforeach
							</ul>
						   </div>

						   <div class="oppor-create-card__content--cmmn-heading">Focus areas</div>
						   <div class="cmmn__pills common_pills__black-border">
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
						@if(Auth::user()->id !=  $opportunity_data->org_uid && empty($opportunity_data->job_start_date) && empty($opportunity_data->job_complete_date)) 
							@if(($opportunity_data->apply == config('kloves.FLAG_SET'))  && ($opportunity_data->approve == config('kloves.OPP_APPLY_NEW') || $opportunity_data->approve == config('kloves.OPP_APPLY_APPROVED')) )
								<a class="withdrawBtn{{$opportunity_data->opp_id}} common-card-apply-btn appliedOpp{{$opportunity_data->opp_id}}"  data-oid="{{$opportunity_data->opp_id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($opportunity_data->opp_id)) }}">{{ __('Withdraw') }}</a>
							@else
								<a class="applyBtn{{$opportunity_data->opp_id}} common-card-apply-btn"  data-oid="{{$opportunity_data->opp_id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($opportunity_data->opp_id)) }}">Apply</a>
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
			<a href="{{ route('list-opportunity') }}"><p class="show-more">Show More</p></a>
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
				var obj = JSON.parse( data.responseText );  //console.log(obj);
				if(obj.status==1){
					if(obj.action=='APPLY'){
						$('a[class^="applyBtn"]').each(function( index ) {
							if($(this).data("oid") == oppID){
								$(this).html('Withdraw');
								$(this).removeClass();
								$(this).addClass('withdrawBtn'+oppID);
								$('.applyStatusStrip').html('<i class="fas fa-clock" aria-hidden="true"></i> Awaiting decision');
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

	$(document).on('click',"a[class^='withdrawBtn']",function(e){ 
		e.stopPropagation();
		var oppID = $(this).data('oid'); 
		var elem = $(this);
		var url = "<?=url('opportunity/withdraw', Crypt::encrypt($opportunity_data->opp_id))?>";
		performOpportunityWithdrawAction(elem, url, oppID);
	})

	function performOpportunityWithdrawAction(elem, url, oppID){
		$.ajax({
			url: url,
			type: "GET",
			data:{},
			dataType: 'JSON',
			beforeSend: function(){
				var btnHtml = elem.html()
				if(btnHtml=='Withdraw'){
					elem.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Processing')
				}
			},error: function(){
				
			},success: function(){
				
			},complete: function( data ){
				var obj = JSON.parse( data.responseText );  //console.log(obj);
				if(obj.status==1){
					if(obj.action=='WITHDRAW'){
						$('a[class^="withdrawBtn"]').each(function( index ) {
							if($(this).data("oid") == oppID){
								$(this).html('Apply');
								$(this).removeClass();
								$(this).addClass('applyBtn'+oppID);
								$('.applyStatusStrip').html('<i class="fas fa-clock" aria-hidden="true"></i> Apply by <?=date("M d, Y",strtotime($opportunity_data->apply_before))?>');
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


	/** Share Opp Fxn : STARTS **/
	function initVueComponent(){
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
		
	}
	/** Share Opp Fxn : ENDS **/
</script>
@endsection


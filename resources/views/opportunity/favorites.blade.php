@extends('layouts.app')
@section('content')   
<div class="container">
	<div class="row clearfix">
	   <div class="main-contnt-body">
		
		<div class="favorites__wrapper">
			<div class="row">
			   <div class="col-md-12">
				<div class="opportunities__wrapper--search-section__suggested-searches--cards favorites__wrapper--favorite-cards">
				   <div class="search-drawer-cards">						 
		    
					<div class="container">
						<p>Favorites</p>
					<div class="row clearfix">
					@if($favoritesOpportunities)
						
						@foreach ($favoritesOpportunities as $favRow)
							<div id="card-wrapper-{{ $favRow['oid'] }}" class="col-md-3 card-wrapper">
										<div class="main-page-cmmn-feed-card main-page__cmmn-card favorites-cmmn__cards">

										<div class="favorites-cmmn__cards--dots-menu">
											<i class="fas fa-ellipsis-h" aria-hidden="true"></i>
										</div>
										<div class="favorite-page-cmmn-card__heading for-element-with--blue-marguerite-bg">
											Apply by  {{ date_format(date_create($favRow['opportunity']['apply_before']),"M d, Y") }}
										</div>

										<div class="main-page-cmmn-feed__content-area favorite_page--cntnt">

												<div class="main-page-cmmn-feed-card__heading">
													<a href="{{ url('view-opportunity', Crypt::encrypt($favRow['oid'])) }}">{{$favRow['opportunity']['opportunity']}}</a>
												</div>
												<div class="main-page-cmmn-feed-card__desc">
													{{ char_trim($favRow['opportunity']['opportunity_desc'],65) }}
												</div>
												@if(Auth::user()->id != $favRow['opportunity']['org_uid']) 
													@if(($favRow['apply'] == config('kloves.FLAG_SET'))  && ($favRow['approve'] == config('kloves.OPP_APPLY_NEW') || $favRow['approve'] == config('kloves.OPP_APPLY_APPROVED')) )
														<a id="withdrawCardBtn{{$favRow['oid']}}" class="main-page-cmmn-feed-card__action-btn favorite--card-action__button"  data-oid="{{$favRow['oid']}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($favRow['oid'])) }}">{{ __('Withdraw') }}</a>
													@else
														<a id="applyCardBtn{{$favRow['oid']}}" class="main-page-cmmn-feed-card__action-btn favorite--card-action__button"  data-oid="{{$favRow['oid']}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($favRow['oid'])) }}" >Interested ?</a>
														
													@endif
												@else
														<a href="javascript:void(0)" class="main-page-cmmn-feed-card__action-btn-none" style="cursor:none">&nbsp;</a>
												@endif	
												<!--<a href="#">
													<div class="main-page-cmmn-feed-card__action-btn favorite--card-action__button">
														<span>Interested ?</span>
													</div>
												</a>-->

												<div class="favorite_page--cntnt__list">
													<ul>
														<li><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="common-semibold-heading">{{$favRow['opportunity']['tokens']}}</span></li>
														<li class="common-semibold-heading">{{$favRow['opportunity']['expert_hrs']}}hrs/wk</li>
														<li><span class="common-semibold-heading">{{ isset($favRow['opportunity']['approved_applicants'])?count( $favRow['opportunity']['approved_applicants'] ): '0' }}</span> of <span class="common-semibold-heading">{{  ($favRow['opportunity']['expert_qty']) ? $favRow['opportunity']['expert_qty'] : '0'  }}</span> candidate(s)</li>
														<li><span class="common-semibold-heading">Reward:</span> {{$favRow['opportunity']['rewards']}} </li>
													</ul>
												</div>
							
										</div>
								
										<div class="main-page-cmmn-feed-card__footer-area favorite-card__footer-area">
										<div class="row ">
											<div class="col-md-1 for-common-linked-text__style">
												
												@if(!empty($favRow["opportunity"]['creator']["profile"]["image_name"]))
												<a href="{{ url('profile', Crypt::encrypt($favRow['opportunity']['creator']['id'])) }}"><div class="favorite-page-cmn-card__user-pic" style="background: url('{{ $favRow['opportunity']['creator']['profile_image']['profile_image'] }}') ;"></div></a>
												@else
													<div class="favorite-page-cmn-card__user-pic for-common-linked-text__style">
													<a href="{{ url('profile', Crypt::encrypt($favRow['opportunity']['creator']['id'])) }}"><i class="fas fa-user-circle fa-2x" aria-hidden="true"></i></a>
													</div>
												@endif
												
											</div>

											<div class="col-md-5 for-null-paddng-right">
												<div class="main-page-cmmn-feed-card__footer-area--desg for-common-linked-text__style">
												<a href="{{ url('profile', Crypt::encrypt($favRow['opportunity']['creator']['id'])) }}">{{ $favRow['opportunity']['creator']['firstName'] }}</a>
												</div>
												<div class="main-page-cmmn-feed-card__footer-area--dept">{{ $favRow['opportunity']['creator']['profile']['department'] }}</div>
											</div>
																				
						
											<div class="col-md-5 for-null-paddng">
												<div class="main-page-cmmn-feed-card__footer--social-icons">
													@include('opportunity.common.fav-action-card')
												</div>
											</div>

										</div>
										</div>


									
								</div>
							</div>
							   @endforeach
						
						@endif
						@if($favoritesOpportunities)
							<div class="no_favorites hidden" id="no_favorites"><p>No favorites yet.</p></div>
						@else 
							<div class="no_favorites" id="no_favorites"><p>No favorites yet.</p></div>
						@endif
						   </div>
						   </div>
						   <!---------->
					</div>
					
				</div>
				</div>
			</div>
		</div><!-----favorites-wrapper-END-->

	   </div>
	</div>
</div>
<script type="text/javascript">
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

	/** remove card if marked unfav : starts **/
	$(document).on('click',"a[class^='favOppBtn']",function(e){
		e.stopPropagation();
		var oid = $(this).attr('data-oid')
		$('#card-wrapper-'+oid).detach();
		
		if ($('.card-wrapper').length == 0){
			$('#no_favorites').removeClass('hidden');
		}
	}); 
	/** remove card if marked unfav : ends **/
</script>
@endsection


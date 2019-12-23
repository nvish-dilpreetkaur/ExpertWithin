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
					@foreach ($favoritesOpportunities as $favRow)
						 <!----1-->
						<div class="col-md-3">
									<div class="main-page-cmmn-feed-card main-page__cmmn-card favorites-cmmn__cards">

									<div class="favorites-cmmn__cards--dots-menu">
										<i class="fas fa-ellipsis-h" aria-hidden="true"></i>
									</div>
									<div class="favorite-page-cmmn-card__heading for-element-with--blue-marguerite-bg">
										Apply by  {{ date_format(date_create($favRow['opportunity']['apply_before']),"M d, Y") }}
									</div>

									<div class="main-page-cmmn-feed__content-area favorite_page--cntnt">

											<div class="main-page-cmmn-feed-card__heading">
												<a href="#">{{$favRow['opportunity']['opportunity']}}</a>
											</div>
											<div class="main-page-cmmn-feed-card__desc">
												{{ char_trim($favRow['opportunity']['opportunity_desc'],105) }}
											</div>
											<a href="#">
												<div class="main-page-cmmn-feed-card__action-btn favorite--card-action__button">
													<span>Interested ?</span>
												</div>
											</a>
											<div class="favorite_page--cntnt__list">
												<ul>
													<li><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="common-semibold-heading">{{$favRow['opportunity']['tokens']}}</span></li>
													<li class="common-semibold-heading">{{$favRow['opportunity']['expert_hrs']}}hrs/wk</li>
													<li><span class="common-semibold-heading">0</span> of <span class="common-semibold-heading">1</span> candidate(s)</li>
													<li><span class="common-semibold-heading">Reward:</span> {{$favRow['opportunity']['rewards']}} </li>
												</ul>
											</div>
						
									</div>
							
									<div class="main-page-cmmn-feed-card__footer-area favorite-card__footer-area">
									<div class="row ">
										<div class="col-md-1">
											<div class="favorite-page-cmn-card__user-pic">
											@if(!empty($favRow["opportunity"]['creator']["profile"]["image_name"]))
												<img src="{{ URL::asset('uploads/'.$favRow['opportunity']['creator']['profile']['image_name']) }}">
											@else
												<i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
											@endif
											</div>
										</div>

										<div class="col-md-5 for-null-paddng-right">
											<div class="main-page-cmmn-feed-card__footer-area--desg">{{ $favRow['opportunity']['creator']['firstName'] }}</div>
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

</script>
@endsection


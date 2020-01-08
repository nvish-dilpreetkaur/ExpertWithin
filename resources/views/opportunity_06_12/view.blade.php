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
					   <div class="col-md-1">
						<i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
					   </div>
					   <div class="col-md-2 for-null-paddng">
						<div class="main-page-cmmn-feed-card__footer-area--desg">{{ $opportunity_data->uname }}</div>
						<div class="main-page-cmmn-feed-card__footer-area--dept">{{ $opportunity_data->department }}</div>
					   </div>
					   <div class="col-md-4 for-null-paddng">
						<div class="opportunity-detail-page__card--social-icons">
						   <i class="far fa-thumbs-up" aria-hidden="true"></i>
						   <i class="far fa-heart" aria-hidden="true"></i>
						   <i class="far fa-comment" aria-hidden="true"></i>
						   <i class="far fa-share-square" aria-hidden="true"></i>
						</div>
					   </div>
					   <div class="col-md-5">
						<div class="opportunity-detail-page__card--apply-btn">
						   <a href="#">Apply</a>
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
							   Last day to apply: {{ date("d M, Y",strtotime($opportunity_data->apply_before)) }}
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
						   <a href="#">Apply</a>
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

			   <!--------->

			   <!-------->

			   <!----1-->
			   <div class="main-page-cmmn-feed-card main-page__cmmn-card oppor-detail__cmmn-card dropdown">
				<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							 <i class="fas fa-ellipsis-h"></i>
							</div>
				   <div class="dropdown-menu dots__options-list--for-feed dots__options-list--oppor-detail">
					<ul>
					   <li><a href="https://www.google.com/">Sort by</a></li>
					   <li><a href="https://www.google.com/">Draft</a></li>
					   <li><a href="https://www.google.com/">Publish</a></li>
					   <li><a href="https://www.google.com/">Screen</a></li>
					   <li><a href="https://www.google.com/">Complete</a></li>
					   <li><a href="https://www.google.com/">Cancel</a></li>
					</ul>
				   </div>
				<!-- </div> -->
				<div class="main-page-cmmn-feed-card__top-blue-banner">
				   <p>$150 Gift Card</p>
				</div>
				<div class="main-page-cmmn-feed-card__heading blue-txt-clr">
				   Collaborate on new storyline for Chelos
				</div>
				<div class="main-page-cmmn-feed-card__desc">
				   Assist in providing hardware and software solutions enabling delivery of the latest Kloves technologies…
				</div>
				<div class="main-page-cmmn-feed-card__coins-info">
				   <i class="fas fa-coins gold-coins-color"></i><span>25</span>
				</div>
				<div class="main-page-cmmn-feed-card__footer-area--border"></div>
				<div class="main-page-cmmn-feed-card__footer-area oppor-create-card__footer">
				   <div class="row clearfix">
					<div class="col-md-1">
					   <i class='fas fa-user-circle fa-2x'></i>
					</div>
					<div class="col-md-5">
					   <div class="main-page-cmmn-feed-card__footer-area--desg">Vincent Lawson</div>
					   <div class="main-page-cmmn-feed-card__footer-area--dept">IT Department</div>
					</div>
					<div class="col-md-5">
					   <div class="main-page-cmmn-feed-card__footer--social-icons">
						<i class="far fa-thumbs-up"></i>
						<i class="far fa-heart"></i>
						<i class="far fa-comment"></i>
						<i class="far fa-share-square"></i>
					   </div>
					</div>
				   </div>
				</div>
			   </div>
			   <!------FEED-CARD-ENDS-HERE-->
			   <!---------->
			   <!---2--->
			   <div class="main-page-cmmn-feed-card main-page__cmmn-card oppor-detail__cmmn-card">
				<i class="fas fa-ellipsis-h card-option-dots"></i>
				<div class="main-page-cmmn-feed-card__top-blue-banner">
				   <p>$150 Gift Card</p>
				</div>
				<div class="main-page-cmmn-feed-card__heading blue-txt-clr">
				   Audio Technology for TV
				</div>
				<div class="main-page-cmmn-feed-card__desc">
				   Help to maintain the QA environment, assist in design, write & execute tests of audio coding & audio processing…
				</div>
				<div class="main-page-cmmn-feed-card__coins-info">
				   <i class="fas fa-coins gold-coins-color"></i><span>25</span>
				</div>
				<div class="main-page-cmmn-feed-card__footer-area--border"></div>
				<div class="main-page-cmmn-feed-card__footer-area oppor-create-card__footer">
				   <div class="row clearfix">
					<div class="col-md-1">
					   <i class='fas fa-user-circle fa-2x'></i>
					</div>
					<div class="col-md-5">
					   <div class="main-page-cmmn-feed-card__footer-area--desg">Vincent Lawson</div>
					   <div class="main-page-cmmn-feed-card__footer-area--dept">IT Department</div>
					</div>
					<div class="col-md-5">
					   <div class="main-page-cmmn-feed-card__footer--social-icons">
						<i class="far fa-thumbs-up"></i>
						<i class="far fa-heart"></i>
						<i class="far fa-comment"></i>
						<i class="far fa-share-square"></i>
					   </div>
					</div>
				   </div>
				</div>
			   </div>
			   <!------FEED-CARD-ENDS-HERE-->
		
			   <!------FEED-CARD-ENDS-HERE-->
		
			   <!-------CARD-ENDS-HERE-->
			</div>
			<div class="col-md-12">
			<div class="main-page__cmmn-card--footer">
				<p class="show-more">Show More</p>
			</div>
		   </div>
		</div>
		   <!--RIGHT-SECTION-->
		</div>
		</div><!-----opportunity-details__wrapper-END-->
	   </div>
	</div>
</div>
@endsection
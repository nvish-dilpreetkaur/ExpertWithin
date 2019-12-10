@extends('layouts.app')
@section('content')  
 <!-- <link rel="stylesheet" href="assets/css/all.css">  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.min.css">
   <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css'>
   <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css'>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
	<div class="main-contnt-body" id="profile-page">
				<div class="profile-section-outer">
					<div class="">
						<div class="profile-sec__cmmn-tile">
							<form action="#" id="usr_profile" name="usr_profile"  accept-charset="multipart/form-data" onsubmit="return false">
							<div class="profile-sec__cmmn-tile--header">
								<div class="profile-sec__cmmn-tile--heading">
									Profile
								</div>
								<div class="profile-sec__edit-icon" data-toggle="modal" data-target="#editAbout">
									<i class="fas fa-edit" aria-hidden="true" id="editProfile"></i>
								</div>
								<div class="profile-sec__edit-icon--optimize">
									<i class="fab fa-linkedin"></i>Optimize with LinkedIn
								</div>
							</div>
						<div class="row">
						 <div class="profile-sec__user-details--left">
						   <div class="user-profile__pic-details flex-box__column">
							  <div class="profile-sec__user-image">
								 <div class="avatar-upload">
									   <div class="avatar-edit hidden" id="avatar_edit">
										   <input type='file' id="imageUpload" name="imageUpload" accept=".png, .jpg, .jpeg" />
										   <label for="imageUpload"></label>
									   </div>
									   <div class="avatar-preview">
										   @if(!empty($users->image_name))
												<div id="imagePreview" style="background-image: url('{{$users->image_name}}');"></div>
										   @else
												<div id="imagePreview" style="background-image: url('../images/user-pic.png');"></div>
										   @endif	
										   <input type='hidden' id="old_image" value="" />	
									   </div>
								   </div>


							  </div>
						   </div>
						   <div class="profile-sec__user-details flex-box__column">
							  <!-- Frank Williamson -->
									<div class="form-group hidden" id="user_name_input" >
										  <input type="text" class="form-control frminput" id="uname-profile" 
										  placeholder="Name" 
										  name="uname" required="" value="{{$users->firstName}}">
										  <div class="valid-feedback">Valid.</div>
										  <div class="invalid-feedback" id="uname-error">Please fill out this field.</div>
									</div>
									<div id="user_name_text">{{$users->firstName}}</div>
							  <p class="profile-sec__user-details--info">
								 <!-- Creative Director -->
								   <div class="form-group hidden" id="designation_input">
										 <input type="text" class="form-control frminput" id="designation-profile" 
										 placeholder="Designation" 
										 name="designation" required="" value="{{$users->designation}}">
										 <div class="valid-feedback">Valid.</div>
										  <div class="invalid-feedback" id="designation-error">Please fill out this field.</div>
								   </div>
								   <div id="designation_text">{{$users->designation}}</div>
							  </p>
						   </div>
						</div>
							<!---------middle-section-->
								<div class="profile-sec__user-details--middle">
								   <ul>
									  <li class="profile-sec__card-content--heading">
										 Department       
									  </li>
									  <!-- <li class="form-pillbox form-group user-profile-page--for-userInfo"> Department Hai</li> -->
										<li class="form-pillbox form-group user-profile-page--for-userInfo hidden" id="dept_input"> 
											 <input type="text" class="form-control frminput" id="dept-profile" 
										 placeholder="Department"  name="dept" required="" value="{{$users->department}}">
											<div class="valid-feedback">Valid.</div>
										  <div class="invalid-feedback" id="dept-error">Please fill out this field.</div>		
										 </li>
										 <li class="form-pillbox form-group user-profile-page--for-userInfo" id="dept_text">{{$users->department}}</li>
									   <li class="profile-sec__card-content--heading">
											   Manager      
											</li>
											<!-- <li class="form-pillbox form-group user-profile-page--for-userInfo"> Manager Hai</li> -->
											<li class="form-pillbox form-group user-profile-page--for-userInfo clearfix hidden" id="manager_input"> 
												   <input type="text" class="form-control frminput" id="manager-profile" 
										 placeholder="Manager"  name="manager" required="" value="{{$users->manager}}">    
													<div class="valid-feedback">Valid.</div>
													<div class="invalid-feedback" id="manager-error">Please fill out this field.</div>
											   </li>
											   <li class="form-pillbox form-group user-profile-page--for-userInfo clearfix" id="manager_text">{{$users->manager}}</li>


											   <li class="profile-sec__card-content--heading">
													 Availability      
												  </li>
												  <!-- <li class="form-pillbox form-group user-profile-page--for-userInfo"> Available Hai</li> -->
											   <li class="form-pillbox form-group  user-profile-page--for-userInfo clearfix hidden" id="availability_input"> 
													  <input type="text" class="form-control frminput" id="availability-profile" 
										 placeholder="Availability"  name="availability" required="" value="{{$users->availability}}">             
													<div class="valid-feedback">Valid.</div>
													<div class="invalid-feedback" id="availability-error">Please fill out this field.</div>
												  </li>
												 <li class="form-pillbox form-group  user-profile-page--for-userInfo clearfix" id="availability_text">{{$users->availability}}</li>


											   <li class="profile-sec__card-content--heading">
													 Team Members      
												  </li>
												  <!-- <li class="form-pillbox form-group user-profile-page--for-userInfo"> Team Hai</li> -->
											   <li class="form-pillbox form-group user-profile-page--for-userInfo clearfix">      
													 <div>9</div>     
												  </li>


											</ul>
										 </div>
										
										<!--------------------------------->

										<div class="profile-sec__user-details--right">
										   <ul>
											  <li class="profile-sec__card-content--heading">About</li>
											  <li class="profile-sec__card-content--content hidden" id="about_input">
												  <div class="form-group">
														<input type="text" class="form-control frminput" id="about-profile" 
														placeholder="About..." 
														name="about" required="" value="{{$users->about}}">
														<div class="valid-feedback">Valid.</div>
														<div class="invalid-feedback" id="about-error">Please fill out this field.</div>
												  </div>
											  </li>
											  <li class="profile-sec__card-content--content" id="about_text">{{$users->about}}</li>
											  <li class="profile-sec__card-content--heading">Aspirations</li>
											  <li class="profile-sec__card-content--content hidden" id="aspirations_input">
												  <div class="form-group">
														<input type="text" class="form-control frminput" id="aspirations-profile" 
														placeholder="Aspirations...." 
														name="aspirations" required="" value="{{$users->aspirations}}">
														<div class="valid-feedback">Valid.</div>
														<div class="invalid-feedback" id="aspirations-error">Please fill out this field.</div>
												  </div>
											  </li>
											 <li class="profile-sec__card-content--content" id="aspirations_text">{{$users->aspirations}}</li>
											   <li class="profile-sec__card-content--heading hidden"  id="submit_btn">	
													<div class="cmmn-edit-save-material-btn save_profile_details " data-type="profile">Save</div>  
													<div class="cmmn-edit-save-material-btn " id="camcel_profile">Cancel</div> 
												</li>  
										   </ul>  
										   
										</div>
							</div>			
							 </div>
							
						 </div>
						</form>
			 			
						
						
						
						<div class="profile-sec__cmmn-tiles--wrapper">
							<div class="profile-sec__cmmn-tile--left-side profile__swiper-section">
								<div class="profile-sec__cmmn-tile">
									<div class="profile-sec__swiper-slider">
										<div class="swiper-container">
											<div class="swiper-wrapper">
												<div class="swiper-slide">
													<div class="main-page-cmmn-slider__top-white-banner">
														Lunch for two
													</div>
													<div class="main-page-slider__cntnt">
														Restock merchandize at the Exchange
													</div>
												</div>
												<!------->
												<div class="swiper-slide">
													<div class="main-page-cmmn-slider__top-white-banner">
														Floating PTO
													</div>
													<div class="main-page-slider__cntnt">
														Create wireframe workflows mockups
													</div>
												</div>
												<!--------->
												<div class="swiper-slide">
													<div class="main-page-cmmn-slider__top-white-banner">
														Movie Night
													</div>
													<div class="main-page-slider__cntnt">
														Slideshow presentation deck for new products
													</div>
												</div>
												<!--------->
												<div class="swiper-slide">
													<div class="main-page-cmmn-slider__top-white-banner">
														Lunch for two
													</div>
													<div class="main-page-slider__cntnt">
														Restock merchandize at the Exchange
													</div>
												</div>
												<!--------->
												<div class="swiper-slide">
													<div class="main-page-cmmn-slider__top-white-banner">
														Floating PTO
													</div>
													<div class="main-page-slider__cntnt">
														Create wireframe workflows mockups
													</div>
												</div>
												<!--------->
											</div>
										</div>
									</div>
								</div>
							</div>


							<div class="profile-sec__cmmn-tile--right-side profile__carousel-section">
								<div class="profile-sec__cmmn-tile">
									<div class="profile-sec__carousel">
										<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
											<ol class="carousel-indicators">
												<li data-target="#carouselExampleIndicators" data-slide-to="0"
													class="active"></li>
												<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
												<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
											</ol>
											<div class="carousel-inner">
												<div class="carousel-item active">
													<div class="profile__carousel-item--heading">
														What people are saying about you
													</div>
													<div class="profile__carousel-item--content">
														<div class="row">
															<div class="col-md-2">
																<i class="fas fa-user-circle fa-3x"
																	aria-hidden="true"></i>
															</div>

															<div class="col-md-10">
																<span>@Frank Williamson, Thank you for a magnificent job
																	on the welcome aboard pamphlets!
																	#designexpert</span>
																<pspan
																	class="profile__carousel-item--content--subheading">
																	Natasha Vargas, Human Resources</pspan>
															</div>
														</div>
													</div>
												</div>
												<div class="carousel-item">
													<div class="profile__carousel-item--heading">
														What people are saying about you
													</div>
													<div class="profile__carousel-item--content">
														<div class="row">
															<div class="col-md-2">
																<i class="fas fa-user-circle fa-3x"
																	aria-hidden="true"></i>
															</div>

															<div class="col-md-10">
																<span>@Frank Williamson, Thank you for a magnificent job
																	on the welcome aboard pamphlets!
																	#designexpert</span>
																<pspan
																	class="profile__carousel-item--content--subheading">
																	Natasha Vargas, Human Resources</pspan>
															</div>
														</div>
													</div>
												</div>
												<div class="carousel-item">
													<div class="profile__carousel-item--heading">
														What people are saying about you
													</div>
													<div class="profile__carousel-item--content">
														<div class="row">
															<div class="col-md-2">
																<i class="fas fa-user-circle fa-3x"
																	aria-hidden="true"></i>
															</div>

															<div class="col-md-10">
																<span>@Frank Williamson, Thank you for a magnificent job
																	on the welcome aboard pamphlets!
																	#designexpert</span>
																<pspan
																	class="profile__carousel-item--content--subheading">
																	Natasha Vargas, Human Resources</pspan>
															</div>
														</div>
													</div>
												</div>
											</div>
											<a class="carousel-control-prev" href="#carouselExampleIndicators"
												role="button" data-slide="prev">
												<span class="carousel-control-prev-icon" aria-hidden="true"></span>
												<span class="sr-only">Previous</span>
											</a>
											<a class="carousel-control-next" href="#carouselExampleIndicators"
												role="button" data-slide="next">
												<span class="carousel-control-next-icon" aria-hidden="true"></span>
												<span class="sr-only">Next</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!----------------------------------------------------------------------------------------------->
						
						<!-------------------------------------Skills & Focus Area Section----------------------------------------------->
						@php $focus_terms = $terms = []; @endphp
						<div class="profile-sec__cmmn-tiles--wrapper">
							<div class="profile-sec__cmmn-tile--left-side">
							   <div class="profile-sec__cmmn-tile">
								  <div class="profile-sec__skills-area">
									 <div class="profile-sec__cmmn-tile--heading">
										Skills
									 </div>
									 <div class="profile-sec__edit-icon" data-toggle="modal"
										data-target="#editAbout">
										<i class="fas fa-edit" aria-hidden="true" id="editSkill"></i>
									 </div>
									<div class="profile-sec__cmmn-pills" id="skills_show">
										<ul>
										@foreach($user_skills as $uskills)
										    @php $terms[] = $uskills['term_data']['tid']; @endphp
											<li><a>{{$uskills['term_data']['name']}}</a></li>
										@endforeach
										</ul>
									</div>
									 <div  id="skills_edit" class=" hidden">
										  <div class="form-pillbox form-group user-profile-page user-profile-page--for-skills clearfix">
											<select class="multiple-pills-dropdown custom-select sel_skills" name="skills[]" id="skills" multiple="multiple">
											   @foreach($skills as $skill)
													<option value="{{$skill['tid']}}" @if(in_array($skill['tid'],$terms)){{'selected=selected'}} @endif>{{$skill['name']}}</option>
												@endforeach
											</select>
											<div class="valid-feedback">Valid.</div>
											<div class="invalid-feedback" id="skills-error">Please fill out this field.</div>
										 </div> 
										 <div class="cmmn-edit-save-material-btn save_data" data-action="1" data-type="skills">Save</div>  
										 <div class="cmmn-edit-save-material-btn" id="camcel_skills">Cancel</div>  
									 </div>         
								  </div>
							   </div>
							</div>
							<div class="profile-sec__cmmn-tile--right-side profile-sec__cmmn-tile">
								<div class="profile-sec__cmmn-tile--heading">
									Focus Area
								</div>
								<div class="profile-sec__edit-icon" data-toggle="modal" data-target="#editAbout">
									<i class="fas fa-edit" aria-hidden="true" id="editFocus"></i>
								</div>
								<div class="profile-sec__cmmn-pills"  id="focus_show">
									<ul>
										@foreach($user_focus as $usr_fc)
										    @php $focus_terms[] = $usr_fc['term_data']['tid']; @endphp
											<li><a>{{$usr_fc['term_data']['name']}}</a></li>
										@endforeach
									</ul>
								</div>
									<div id="edit_focus" class="hidden">
										<div class="form-pillbox form-group user-profile-page user-profile-page--for-focus user-profile-page__pills-dropdown--for-focus-area clearfix">
										 <select class="multiple-pills-dropdown custom-select sel_focus" name="focusArea[]" id="focus" multiple="multiple">
										      @foreach($focus as $fc)
													<option value="{{$fc['tid']}}" @if(in_array($fc['tid'],$focus_terms)){{'selected=selected'}} @endif>{{$fc['name']}}</option>
												@endforeach
										 </select>
										 <div class="valid-feedback">Valid.</div>
										 <div class="invalid-feedback" id="focus-error">Please fill out this field.</div>
									   </div>
									   <div class="cmmn-edit-save-material-btn save_data" data-action="3" data-type="focus">Save</div>
									   <div class="cmmn-edit-save-material-btn" id="camcel_focus">Cancel</div> 
								   </div> 
								</div>
							</div>
						</div>
						<!----------------------------------------------------------------------------------------------->
						<div class="profile-sec__cmmn-tile">
							<div class="profile-sec__cmmn-tile--heading">
								Activities
							</div>
							<div class="profile-sec__edit-icon" data-toggle="modal" data-target="#editAbout">
								<i class="fas fa-edit" aria-hidden="true" id="editActivity"></i>
							</div>
							<div class="profile-sec__card-content--ful-width__cmmn" id="show_activity">{{$users->activities}}</div>
							<div class="form-group cmmn-profile-page__textfield hidden" id="edit_activity">
							   <div class="form-group">
									 <input type="text" class="form-control frminput" id="activity-profile" 
									 placeholder="Frank Williamson #Kudos Simple yet profound work, always! #GreatPresentation #graphicsdesign #brandingexpert" 
									 name="activity" required="" value="{{$users->activities}}">
									 <div class="valid-feedback">Valid.</div>
								     <div class="invalid-feedback" id="activity-error">Please fill out this field.</div>
							   </div>
							    <div class="cmmn-edit-save-material-btn save_profile_details" data-type="activity">Save</div>
								<div class="cmmn-edit-save-material-btn" id="camcel_activity">Cancel</div> 
							</div>
						</div>
						<!------------------>
						
						<div class="profile-sec__cmmn-tile">
							<div class="profile-sec__cmmn-tile--heading">
								Certificates
							</div>
							<div class="profile-sec__edit-icon" data-toggle="modal" data-target="#editAbout">
								<i class="fas fa-edit" aria-hidden="true" id="editCertificate"></i>
							</div>
							<div class="profile-sec__card-content--ful-width__cmmn" id="show_certificate">{{$users->certificate}}</div>
							<div class="form-group cmmn-profile-page__textfield hidden" id="edit_certificate">
								 <div class="form-group">
									   <input type="text" class="form-control frminput" id="certificate-profile" 
									   placeholder="  Design Sprint Certificate" name="certificate" required="" value="{{$users->certificate}}">
									    <div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback" id="certificate-error">Please fill out this field.</div>
								 </div>
								 <div class="cmmn-edit-save-material-btn save_profile_details" data-type="certificate">Save</div>
								 <div class="cmmn-edit-save-material-btn" id="camcel_certificate">Cancel</div> 
							</div>
						</div>
					</div>
					<!-------row end-->
				</div>
			</div>
			
         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
           crossorigin="anonymous"></script>
         <script src='https://unpkg.com/bootstrap-material-design@4.0.0-beta.3/dist/js/bootstrap-material-design.js'></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" 
           crossorigin="anonymous"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
         <script src="{{ URL::asset('js/profile.js') }}"></script>
         
@endsection


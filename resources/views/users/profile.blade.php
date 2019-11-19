@extends('layouts.app')
@section('content')  
<div class="main-contnt-body">
			<div class="profile-section-outer">
				<div class="profile-sec__cmmn-tile">
					<div class="row clearfix">
							<div class="col-md-11">
								<h3>Profile</h3>
							</div>
							<div class="col-md-1">
									<div class="profile-sec__edit-icon" data-toggle="modal" data-target="#editProfile">
										<i class="fas fa-edit"></i>
									</div>
							</div>
						<div class="col-md-5">
						    <div class="row clearfix">
							<div class="col-md-1"></div>
								<div class="col-md-5">
									<div class="profile-sec__user-image">
									<i class='fas fa-user-circle fa-8x'></i>
									</div>
								</div>
								<div class="col-md-6">
									<div class="profile-sec__user-details">
										<h3>{{  old('firstname', @$users->firstName) }}</h3>
										<h4>Sr UX/UI Designer</h4>
										<div class="profile-sec__user-details--info">
											<h5>Availability: <span class="for-text-lite">{{  old('availability', @$users->availability) }}</span></h5>
											<h6>Manager: <span class="for-text-lite">
												@php 
													$mdata = get_user_manager(old('manager', @$users->manager_id))
												@endphp
												{{ ($mdata) ? $mdata->mname : '-' }}
											</span>
											</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="profile-sec__skills-area">
								<h5>Skills:</h5>
								<div class="profile-sec__cmmn-pills">
									<ul>
										<li>UI</li>
										<li>Android</li>
										<li>iOS</li>
										<li>Front end Development</li>
										<li>Adobe XD</li>
										<li>Adobe PS</li>
									</ul>
								</div>
								<h6>Focus Area:</h6>
								<div class="profile-sec__cmmn-pills">
									<ul>
										<li>Communications</li>
										<li>Colaboration</li>
										<li>Analytical and problem-solving</li>
										<li>Personal Management</li>
										<li>Leadership Management</li>
										<li>Leadership Management</li>
										<li>Sales and Marketing</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

			<!--Profile-About-->
			<div class="profile-sec__cmmn-tile">
				<div class="row clearfix">
					<div class="col-md-11">
						<h3>About</h3>
						<p id="notes_lbl">{{ isset($users->notes) ? $users->notes : (old('notes') ? old('notes') : 'NA') }}</p>
					</div>
					<div class="col-md-1">
						<div class="profile-sec__edit-icon" data-toggle="modal" data-target="#editAbout">
							<i class="fas fa-edit"></i>
						</div>
					</div>
				</div>
			</div>


			<!--Profile-Aspirations-->
			<div class="profile-sec__cmmn-tile">
					<div class="row clearfix">
						<div class="col-md-11">
							<h3>Aspirations</h3>
							<p id="aspirations_lbl">{{ isset($users->aspirations) ? $users->aspirations : (old('aspirations') ? old('aspirations') : 'NA') }}<p>
						</div>
						<div class="col-md-1">
							<div class="profile-sec__edit-icon" data-toggle="modal" data-target="#editAspirations">
								<i class="fas fa-edit"></i>
							</div>
						</div>
          </div>
				</div>


			<!--Profile-Activities-->
			<div class="profile-sec__cmmn-tile" id="activitiesWrapper">
				@include('users.profile.activities-section')
			</div>
		</div> <!------Profile-Section-Outer-Closed-->


	</div>
  @include('users.profile.profile-modals')
<script type="text/javascript">
$(".profileEditForm").submit(function(e) {
	//alert('d'); return false;
	e.preventDefault(); // avoid to execute the actual submit of the form.
	var form = $(this);
	var url = form.attr('action');
	var modalID = form.attr('data-modalID'); 
	/*$.each( form.serializeArray(),function(counter,object) {
		console.log(counter) 
		console.log(object) 
	});  return false; */
	$.ajax({
		type: "POST",
		url: url,
		data: form.serializeArray(), // serializes the form's elements.
		beforeSend: function(){
		},error: function(){
			alert('profile update ajax error!')
		},success: function(){
			
		},complete: function( data ){
			var obj = $.parseJSON( data.responseText ); 
			if(obj.type=='success'){
				$('#'+modalID).modal('hide')
				if(modalID=='editActivities'){
					//$("#activities_lbl").html(obj.res_data['activities']);
					$("#activitiesWrapper").html(obj.success_html);
				}
				if(modalID=='editAspirations'){
					$("#aspirations_lbl").html(obj.res_data['aspirations']);
				}
				if(modalID=='editAbout'){
					$("#notes_lbl").html(obj.res_data['notes']);
				}
				
			}else{
				jQuery.each(obj.keys, function(key, value){
					var error_msg = obj.errors[key] //console.log("#"+value)
            			$("#"+value).addClass("is-invalid");
            			$("#"+value).closest(".form-group").find(".input-error-msg").text(error_msg);
				});
			}
		},
	});


});
</script>
@endsection


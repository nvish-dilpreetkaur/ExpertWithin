$(document).on('click','#editSkill', function() {
				var skills_values = [];
				$('#skills option').each(function() {
					if($(this).attr('selected') !== undefined) {					
						skills_values.push( $(this).attr('value') );
					}
				});
				$('.sel_skills ').val(skills_values).trigger('change');
				$('#skills_show').addClass('hidden');
				$('#editSkill').parent().addClass('hidden');
				$('#skills_edit').removeClass('hidden');
			});
			$(document).on('click','#camcel_skills', function() {
				$('#skills_show').removeClass('hidden');
				$('#editSkill').parent().removeClass('hidden');
				$('#skills_edit').addClass('hidden');
				$('#skills-error').html('');
				$('#skills-error').css('display','none');
			});
			
			$(document).on('click','#editFocus', function() {
				var values = [];
				$('#focus option').each(function() {
					if($(this).attr('selected') !== undefined) {					
						values.push( $(this).attr('value') );
					}
				});
				$('.sel_focus ').val(values).trigger('change');
				$('#focus_show').addClass('hidden');
				$('#editFocus').parent().addClass('hidden');
				$('#edit_focus').removeClass('hidden');
			});
			$(document).on('click','#camcel_focus', function() {
				$('#focus_show').removeClass('hidden');
				$('#editFocus').parent().removeClass('hidden');
				$('#edit_focus').addClass('hidden');
				$('#focus-error').html('');
				$('#focus-error').css('display','none');
			});
			
			$(document).on('click','#editActivity', function() {
				$('#activity-profile').val($('#show_activity').text());
				$('#show_activity').addClass('hidden');
				$('#editActivity').parent().addClass('hidden');
				$('#edit_activity').removeClass('hidden');
				
			});
			$(document).on('click','#camcel_activity', function() {
				$('#show_activity').removeClass('hidden');
				$('#editActivity').parent().removeClass('hidden');
				$('#edit_activity').addClass('hidden');
			});
			
			$(document).on('click','#editCertificate', function() {
				$('#certificate-profile').val($('#show_certificate').text());
				$('#show_certificate').addClass('hidden');
				$('#editCertificate').parent().addClass('hidden');
				$('#edit_certificate').removeClass('hidden');
			});
			$(document).on('click','#camcel_certificate', function() {
				$('#show_certificate').removeClass('hidden');
				$('#editCertificate').parent().removeClass('hidden');
				$('#edit_certificate').addClass('hidden');
			});
			$(document).on('click','#editProfile', function() {
				$('#uname-profile').val($('#user_name_text').text());
				$('#designation-profile').val($('#designation_text').text());
				$('#dept-profile').val($('#dept_text').text());
				$('#manager-profile').val($('#manager_text').text());
				$('#availability-profile').val($('#availability_text').text());
				$('#aspirations-profile').val($('#aspirations_text').text());
				
				$(this).parent().addClass('hidden');
				$('#avatar_edit').removeClass('hidden');
				$('#user_name_input').removeClass('hidden');
				$('#designation_input').removeClass('hidden');
				$('#dept_input').removeClass('hidden');
				$('#manager_input').removeClass('hidden');
				$('#availability_input').removeClass('hidden');
				$('#about_input').removeClass('hidden');
				$('#aspirations_input').removeClass('hidden');
				$('#submit_btn').removeClass('hidden');
				
				$('#user_name_text').addClass('hidden');
				$('#designation_text').addClass('hidden');
				$('#dept_text').addClass('hidden');
				$('#manager_text').addClass('hidden');
				$('#availability_text').addClass('hidden');
				$('#about_text').addClass('hidden');
				$('#aspirations_text').addClass('hidden');
				
				
				var bg = $('#imagePreview').css('background-image');
				bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
				$('#old_image').val(bg);
			});
			
			$(document).on('click','#camcel_profile', function() {
				$('#editProfile').parent().removeClass('hidden');
				$('#avatar_edit').addClass('hidden');
				$('#user_name_input').addClass('hidden');
				$('#designation_input').addClass('hidden');
				$('#dept_input').addClass('hidden');
				$('#manager_input').addClass('hidden');
				$('#availability_input').addClass('hidden');
				$('#about_input').addClass('hidden');
				$('#aspirations_input').addClass('hidden');
				$('#submit_btn').addClass('hidden');
				
				$('#user_name_text').removeClass('hidden');
				$('#designation_text').removeClass('hidden');
				$('#dept_text').removeClass('hidden');
				$('#manager_text').removeClass('hidden');
				$('#availability_text').removeClass('hidden');
				$('#about_text').removeClass('hidden');
				$('#aspirations_text').removeClass('hidden');
				var imageUrl = $('#old_image').val();
				if(imageUrl == 'none') {
					$('#imagePreview').removeAttr('style');
					$('.pro_img').addClass('fas fa-user-circle fa-9x');
				} else {
					$('#imagePreview').css('background-image', 'url(' + imageUrl + ')');
				}	
			});
			
			$(document).on('change','#skills', function() {
				$('#skills-error').html('');
				$('#skills-error').css('display','none');
			});
			
			$(document).on('change','#focus', function() {
				$('#focus-error').html('');
				$('#focus-error').css('display','none');
			});
			
			/*$(".custom-select").each(function(index, element) {
			  $(this).select2({
				tags: true,
				width: "100%" // just for stack-snippet to show properly
			  });
			});*/
			
			$('.save_data').click(function(){
				var action = $(this).data('action');
				var skills = $("#skills").val();
				var focus = $("#focus").val();
				$.ajax({
					url: SITE_URL + "/user_interests",
					type: 'POST',
					dataType: 'json',
					data: {action:action, skills:skills, focus:focus},
					beforeSend: function(){},
					success: function(data) {
						if(data.status==false) {
							$.each(data.message, function( index, value ) {
								var error_elem =  $("#"+index).closest(".form-group").find(".invalid-feedback");
								error_elem.show()
								error_elem.text(value);
							});
						} else if(data.status==true) {
							var tidArr = [];
							var htmlData = '<ul>';
								$.each(data.term_data, function(key,value) {
   									htmlData += "<li><a>"+value.name+"</a></li>";
   									tidArr.push(value.tid);
   									switch(action) {
										case 1:
											$('#skills option').each(function() {
												if($(this).val() == value.name) {
													$(this).val(value.tid);
													$(this).removeAttr('data-select2-tag');
												}
											});
										break;
										case 3:
											$('#focus option').each(function() {
												if($(this).val() == value.name) {
													$(this).val(value.tid);
													$(this).removeAttr('data-select2-tag');
												}
											});
										break;	
									}
   								});								
							htmlData += '</ul>';
							switch(action) {
								case 1:
									$('#skills_show').html(htmlData);
									$('#skills_show').removeClass('hidden');
									$('#editSkill').parent().removeClass('hidden');
									$('#skills_edit').addClass('hidden');
									$('#skills option').each(function() {
										$(this).removeAttr('selected');
										var sklval = $(this).val();
										if($.inArray(parseInt(sklval),tidArr) !== -1) {				
											$(this).attr('selected', 'selected');
										}
									});
									
								break;
								case 3:
									$('#focus_show').html(htmlData);
									$('#focus_show').removeClass('hidden');
									$('#editFocus').parent().removeClass('hidden');
									$('#edit_focus').addClass('hidden');
									$('#focus option').each(function() {
										$(this).removeAttr('selected');
										var sklval = $(this).val();
										if($.inArray(parseInt(sklval),tidArr) !== -1) {				
											$(this).attr('selected', 'selected');
										}
									});
								break;
							}
						}
					},
					error: function(error) {
						alert('Something went wrong. Please try again.');
					}
				});
			});
			
			$('.save_profile_details').click(function(){
				var action = $(this).data('type');
				var details = new FormData();
				details.append('action', action);
				switch(action) {
					case 'activity':
						details.append('activity', $("#activity-profile").val());
						//var details = $("#activity-profile").val();
					break;
					case 'certificate':
						details.append('certificate', $("#certificate-profile").val());
						//var details = $("#certificate-profile").val();
					break;
					case 'profile':
						//Form data
						var form_data = $('#usr_profile').serializeArray();
						$.each(form_data, function (key, input) {
							details.append(input.name, input.value);
						});
						//File data
						var file_data = $('input[name="imageUpload"]')[0].files;
						for (var i = 0; i < file_data.length; i++) {
							details.append("profile_images", file_data[i]);
						}
					break;
				}
				$.ajax({
					url: SITE_URL + "/save_user_profile",
					type: 'POST',
					dataType: 'json',
					data: details,
					processData: false,
					contentType: false,
					beforeSend: function(){},
					success: function(data) {
						if(data.status==false) {
							$.each(data.message, function( index, value ) {
								var error_elem =  $("#"+index+'-profile').closest(".form-group").find(".invalid-feedback");
								error_elem.show()
								error_elem.text(value);
							});
						} else if(data.status==true) {
							switch(action) {
								case 'activity':
									$('#show_'+action).html(data.details.activity);
									$('#show_activity').removeClass('hidden');
									$('#editActivity').parent().removeClass('hidden');
									$('#edit_activity').addClass('hidden');
									$('#'+action+'-profile').val(data.details.activity);
								break;
								case 'certificate':
									$('#show_'+action).html(data.details.certificate);
									$('#show_certificate').removeClass('hidden');
									$('#editCertificate').parent().removeClass('hidden');
									$('#edit_certificate').addClass('hidden');
									$('#'+action+'-profile').val(data.details.certificate);
								break;
								case 'profile':
									$('#user_name_text').html(data.details.uname);
									$('#designation_text').html(data.details.designation);
									$('#dept_text').html(data.details.dept);
									$('#manager_text').html(data.details.manager);
									$('#availability_text').html(data.details.availability);
									$('#about_text').html(data.details.about);
									$('#aspirations_text').html(data.details.aspirations);
									
									$('#uname-profile').val(data.details.uname);
									$('#designation-profile').val(data.details.designation);
									$('#dept-profile').val(data.details.dept);
									$('#manager-profile').val(data.details.manager);
									$('#availability-profile').val(data.details.availability);
									$('#aspirations-profile').val($('#aspirations_text').text());
								
									$('#editProfile').parent().removeClass('hidden');
									$('#avatar_edit').addClass('hidden');
									$('#user_name_input').addClass('hidden');
									$('#designation_input').addClass('hidden');
									$('#dept_input').addClass('hidden');
									$('#manager_input').addClass('hidden');
									$('#availability_input').addClass('hidden');
									$('#about_input').addClass('hidden');
									$('#aspirations_input').addClass('hidden');
									$('#submit_btn').addClass('hidden');
									
									$('#user_name_text').removeClass('hidden');
									$('#designation_text').removeClass('hidden');
									$('#dept_text').removeClass('hidden');
									$('#manager_text').removeClass('hidden');
									$('#availability_text').removeClass('hidden');
									$('#about_text').removeClass('hidden');
									$('#aspirations_text').removeClass('hidden');
									
									if(data.details.image_name != '') {
										var imageUrl = data.details.image_name;
										$('.cur_image').css('background-image', 'url(' + imageUrl + ')');
										if($('#header_def_pic').length > 0) {
											$('#header_def_pic').removeClass();
											$('#def_pic').removeClass();
										}
										if($('#header_def_image').length > 0) {
											$('#header_def_image').addClass('user-pic__for-profile--header');	
										}										
										$('.pro_img').removeClass();
											
									}
								break;
							}
							
						}
					},
					error: function(error) {
						alert('Something went wrong. Please try again.');
					}
				});
			});
			
			$(document).on('keyup','.frminput', function() {
				var attr_name = $(this).attr('name');
				var val = $(this).val();
				if(val != '') {
					$('#'+attr_name+'-error').html('');
					$('#'+attr_name+'-error').css('display','none');
				}
			});
			
			$(document).ready(function () {
				$(".custom-select").each(function(index, element) {
				  $(this).select2({
						tags: true,
						createTag: function (params) {
							var term = $.trim(params.term);
							var count = 0
							var existsVar = false;
							//check if there is any option already
							if($('#keywords option').length > 0){
								$('#keywords option').each(function(){
									if ($(this).text().toUpperCase() == term.toUpperCase()) {
										existsVar = true
										return false;
									}else{
										existsVar = false
									}
								});
								if(existsVar){
									return null;
								}
								return {
									id: params.term,
									text: params.term,
									newTag: true
								}
							}
							//since select has 0 options, add new without comparing
							else{
								return {
									id: params.term,
									text: params.term,
									newTag: true
								}
							}
						},
						maximumInputLength: 20, // only allow terms up to 20 characters long
						closeOnSelect: true
					  });
				});
			});
			


		<!--EDIT-Profile-About-->
		<div class="modal cmmn-modal-profile-sec" id="editAbout">
			<div class="modal-dialog">
				<div class="modal-content">	
				<form method="post" class="profileEditForm" action="{{ route('update') }}" data-modalID="editAbout">			  
					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Edit About</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>					
					<!-- Modal body -->
					<div class="modal-body">
						<div class="form-group">
							<h5>About</h5>
							<textarea class="char-limit" cols="50" rows="7" placeholder="About" name="notes" data-char-limit="500" id="notes">{{ isset($users->notes) ? $users->notes : old('notes') }}</textarea>
							<div class="char-limit-text"></div>
							<span class="input-error-msg"></span>
						</div>
					</div>					
					<!-- Modal footer -->
					<div class="modal-footer">
							<button type="submit" class="btn btn-primary" ><span>Save</span></button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal"><span>Cancel</span></button>
					</div>					
				</div>
			</div>
		</div>

		<!--EDIT-Profile-Aspirations-->
		<div class="modal cmmn-modal-profile-sec" id="editAspirations">
			<div class="modal-dialog">
				  <div class="modal-content">	
					<form method="post" class="profileEditForm" action="{{ route('update') }}" data-modalID="editAspirations">				  
						<!-- Modal Header -->
						<div class="modal-header">
							<h4 class="modal-title">Edit Aspirations</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>					
						<!-- Modal body -->
						<div class="modal-body">
							<div class="form-group">
								<h5>Aspirations</h5>
								<textarea class="char-limit" cols="50" rows="7" placeholder="Aspirations" name="aspirations" data-char-limit="500" id="aspirations">{{ isset($users->aspirations) ? $users->aspirations : old('aspirations') }}</textarea>
								<div class="char-limit-text"></div>
								<span class="input-error-msg"></span>
							</div>
						</div>					
						<!-- Modal footer -->
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" ><span>Save</span></button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal"><span>Cancel</span></button>
						</div>
					</form>						
				</div>
			</div>
		</div>
	
		<!--EDIT-Profile-Activities-->
		<div class="modal cmmn-modal-profile-sec" id="editActivities">
                  <div class="modal-dialog">
                        <div class="modal-content">
					<form method="post" class="profileEditForm" action="{{ route('update') }}" data-modalID="editActivities">
					<input type="hidden" name="action_slug" value="activities">				  
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                          <h4 class="modal-title">Edit Activities</h4>
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>					
                                    <!-- Modal body -->
                                    <div class="modal-body">
							<div class="form-group">
							<h5>Activities</h5>
							<textarea class="char-limit" cols="50" rows="7" placeholder="Activities" name="activities" data-char-limit="500" id="activities">{{ isset($users->activities) ? $users->activities : old('activities') }}</textarea>
							<div class="char-limit-text"></div>
							<span class="input-error-msg"></span>
							</div>
                                    </div>					
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                          <button type="submit" class="btn btn-primary" ><span>Save</span></button>
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal"><span>Cancel</span></button>
                                    </div>					
                               </form>					
                        </div>
                  </div>
		</div>
		
		<!--EDIT-top-profile-->
		<div class="modal cmmn-modal-profile-sec" id="editProfile">
				<div class="modal-dialog">
					<div class="modal-content">	
					<form method="post" class="profileEditForm" action="{{ route('update') }}" data-modalID="editProfile">			  
						<!-- Modal Header -->
						<div class="modal-header">
							<h4 class="modal-title">Edit Profile</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>					
						<!-- Modal body -->
						<div class="modal-body">
							<div class="form-group">
								<h5>Manager</h5>
								<select class="js-example-basic-multiple form-control" name="manager"  id="manager">
									<option value="">-- Choose Manager--</option>
									@foreach ($managers as $manage)
									<option value="{{ $manage->id }}" {{ ($manage->id==old('manager', @$users->manager_id)) ? "selected" : "" }}>{{ $manage->mname }}</option>
									@endforeach 							  
								</select>
								<span class="input-error-msg"></span>
							</div>
							<div class="form-group">
									<h5>Availability</h5>
									<input type="availability" class="" id="availability" placeholder="Available hours per month" name="availability" value="{{  old('availability', @$users->availability) }}">
									<span class="input-error-msg"></span>
							</div>
							<div class="form-group">
									<h5>Designation</h5>
									<input type="designation" class="" id="designation" placeholder="Senior Software Dev" name="designation" value="{{  old('designation', @$users->designation) }}">
									<span class="input-error-msg"></span>
							</div>
						</div>					
						<!-- Modal footer -->
						<div class="modal-footer">
								<button type="submit" class="btn btn-primary" ><span>Save</span></button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal"><span>Cancel</span></button>
						</div>					
					</div>
				</div>
	</div>
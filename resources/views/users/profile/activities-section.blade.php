
	<div class="row clearfix">
		<div class="col-md-11">
			<h3>Activities</h3>
				<p id="activities_lbl">{{ isset($users->activities) ? $users->activities : (old('activities') ? old('activities') : 'NA') }}<p>
		</div>
		<div class="col-md-1">
			<div class="profile-sec__edit-icon" data-toggle="modal" data-target="#editActivities">
				<i class="fas fa-edit"></i>
			</div>
		</div>
	</div>
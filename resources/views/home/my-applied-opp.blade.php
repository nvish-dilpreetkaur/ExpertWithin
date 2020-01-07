
<div class="main-page__cmmn-card cmmn-card__-title-subtitle widget__applied-opportunity">
	<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fas fa-ellipsis-h"></i>
		<div class="dropdown-menu dots__options-list dots__options-list--for-left-section">
			<ul>
				<li>Sort by</li>
				<li><a href="#">Draft</a></li>
				<li><a href="#">Publish</a></li>
				<li><a href="#">Screen</a></li>
				<li><a href="#">Complete</a></li>
				<li><a href="#">Cancel</a></li>
			</ul>
		</div>
	</div>
	<div class="main-page__cmmn-card--heading"><i class="fas fa-door-open"></i><span>My applied opportunities</span></div>
	@if ($myAppliedOpp != null)
	@foreach($myAppliedOpp as $rowApp)
	<div class="cmmn-card-point-nd-status">
		<p class="blue-txt-clr"><a href="{{ url('view-opportunity', Crypt::encrypt($rowApp->id)) }}">{{ $rowApp->opportunity }}</a></p>
		<p class="blue-highlit-txt"> <?=get_opp_application_status_label($rowApp->approve)?></p>
	</div>
	@endforeach
	@else 
		<p class="">No applied opportunities</p>
	@endif
</div>

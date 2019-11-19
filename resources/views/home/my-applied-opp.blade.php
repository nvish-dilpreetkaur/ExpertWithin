@if ($myAppliedOpp != null)
<div class="main-page__cmmn-card cmmn-card__-title-subtitle">
	<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fas fa-ellipsis-h"></i>
		<div class="dropdown-menu dots__options-list dots__options-list--for-left-section">
			<ul>
				<li><a href="#">Sort by</a></li>
				<li><a href="#">Draft</a></li>
				<li><a href="#">Publish</a></li>
				<li><a href="#">Screen</a></li>
				<li><a href="#">Complete</a></li>
				<li><a href="#">Cancel</a></li>
			</ul>
		</div>
	</div>
	<div class="main-page__cmmn-card--heading"><i class="fas fa-briefcase"></i><span>My applied opportunities</span></div>
	@foreach($myAppliedOpp as $rowApp)
	<div class="cmmn-card-point-nd-status">
		<p class="blue-txt-clr">{{ $rowApp->opportunity }}</p>
		<p class="blue-highlit-txt"> {{ get_opp_application_status_label($rowApp->application_status) }}</p>
	</div>
	@endforeach
</div>
@endif
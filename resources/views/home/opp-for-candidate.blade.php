<div class="widget__candidate-opportunity">
	<div class="card-option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	<i class="fas fa-ellipsis-h"></i>
	<div class="dropdown-menu dots__options-list">
		<ul>
			<li>Sort by</li>
			<li><a href="javascript:void(0)" onclick="javascript:sortWidget('opp-for-candidate',{{ config('kloves.OPP_APPLY_NEW') }})">Draft</a></li>
			<li><a href="javascript:void(0)" onclick="javascript:sortWidget('opp-for-candidate',{{ config('kloves.OPP_APPLY_APPROVED') }})">Publish</a></li>
			<!--<li><a href="javascript:void(0)">Screen</a></li>
			<li><a href="javascript:void(0)">Complete</a></li>,'publish'
			<li><a href="javascript:void(0)">Cancel</a></li>-->
		</ul>
	</div>
	</div>
	<div class="main-page__cmmn-card--heading">
		<i class="fas fa-door-open"></i>
		<span>My opportunities <div>for candidates</div></span>
	</div>
	@foreach ($myOppForCandidates as $oppCandRow)
	<div class="cmmn-card-point-nd-status">
		<p class="black-txt-clr"><a href="{{ ($oppCandRow->status==1)?url('published-opportunity', Crypt::encrypt($oppCandRow->id)):url('create-opportunity', Crypt::encrypt($oppCandRow->id)) }}">{{  ($oppCandRow->opportunity) ? char_trim($oppCandRow->opportunity,40) : '' }}</a></p>
	<p class="white-highlit-txt"><?=get_opp_status_label($oppCandRow->status, $oppCandRow->job_complete_date)?></p>
	</div>
	@endforeach
	<div class="main-page__cmmn-card--footer">
		<p class="show-more">Show More</p>
	</div>
</div>
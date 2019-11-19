@extends('layouts.app')
@section('content')
<section class="main-body" id="list-organizations-page">

	<div class="container">
        <div class="row clearfix">
          <div class="col-md-12">
            <div class="">
              <div class="add-oppor">
				<a href="{{ route('organization') }}">{{ __('Create Organization') }}<i class="fa fa-plus"></i></a>
              </div>
            </div>
          </div>
        </div>
    </div>
	
	<div class="container">
		<div class="inner-oppor-wrapper">
			<div class="col-md-12 inner-wrapper">
			  <div class="row clearfix">
			  <div class="col-md-8">
				  <h1 class="opportunity-heading">Organization List</h1>
			  </div>
			  <div class="col-md-4">
				<ul class="indicator-list">
				  <li>Active <div class=" dot new"></div></li>
				  <li>Inactive <div class="dot closed"></div></li>
				</ul>
				</div>
			  </div>
			</div>
		</div>
	</div>
   
	<div class="container">
		<div class="row seven-cols inner-pages inner-org-headings-wrapper">
		  <div class="col-md-3 org-detail">Organization</div>
		  <div class="col-md-1">Street</div>
		  <div class="col-md-1 for-min-col-width">City</div>
		  <div class="col-md-1 org-detail">State</div>
		  <div class="col-md-1 org-detail">Director</div>
		  <div class="col-md-2 org-detail">Phone</div>
		  <div class="col-md-1 org-detail">Status</div>
		  <div class="col-md-1 org-detail">Action</div>
		</div> 
		 @if(!$organizations->isEmpty())
            @foreach($organizations as $key => $orgRow)
				<div class="row seven-cols org-detail-data main-cntnt-inner org-cntnt-inner">
					
					<div class="col-md-3 org-detail for-width">                              
					   <!--<img src="assets/images/ibm.png" class="org-pic"/>                              -->
					   {{$orgRow->name}}
					</div>
					
					<div class="col-md-1">
					  <div class="org-txt"> {{ $orgRow->street ? $orgRow->street : '' }}</div>
					</div>

					<div class="col-md-1 for-min-col-width">
						<div class="org-txt"> {{ $orgRow->city ? $orgRow->city_name : '' }}</div>
					</div>

					<div class="col-md-1 for-col-width">
						<div class="org-txt">  {{ $orgRow->state ? $orgRow->state_name : '' }}</div>
					</div>

					<div class="col-md-1">
						<div class="org-txt"> {{ $orgRow->director }}</div>
					</div>

					<div class="col-md-2">
						 <div class="org-txt"> {{ $orgRow->phone }}</div>
					 </div>

					<div class="col-md-1">
						<div class="org-detail">
							<!--<a href="#"><div class=" dot new"></div></a>-->
							 @if($orgRow->status == '1')
							<div class=" dot new"></div>
							@else
							<div class=" dot pending"></div>
							@endif
					  </div>
					</div>
					<div class="col-md-1">
						<div class="org-detail">
						   <a title="{{ __('Edit') }}" href="{{ url('organization/edit', Crypt::encrypt($orgRow->id)) }}"><i class="fa fa-edit"></i></a>
							<a title="{{ __('Delete') }}" href="{{ url('organization/delete', Crypt::encrypt($orgRow->id)) }}"><i class="fa fa-trash"></i></a>
						</div>
					</div>
				</div>
			@endforeach
            @if( method_exists($organizations,'links') )
               {{  $organizations ->links() }}
            @endif
        @else
            <p>No organizations created yet!<p>
        @endif
	</div>
</section>
@endsection
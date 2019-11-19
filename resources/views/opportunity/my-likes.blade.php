@extends('layouts.admin')
@section('content')  
@include('common.admin-nav') 
@php
  $mylikes = $results['results'];
  $skills = $results['skills'];
  $focus_areas = $results['focus_areas'];
@endphp
<section class="main-body" id="my-favorites-page">
  <div class="container">
    <div class="favorite-page-redesign">
    <div class="row clearfix">      
      <div class="col-md-12">
        <div class="inner-oppor-wrapper">
          <div class="col-md-12 inner-wrapper">
            <div class="row clearfix">
              <div class="col-md-12">
                <h1 class="opportunity-heading">{{ __('Likes') }}</h1>
              </div>
            </div>
          </div>
          <table class="table">
             <thead>
				<tr class="inner-pages">
					 <th class="w-50 for-table-paddng">OPPORTUNITY</th>
					<th class=" text-left">Manager</th>
           <th class="w-16.6 text-left">Start</th>
           <th class="w-16.6 text-left">End</th>
					 <th class="w-16.6 text-right">Edit</th>
				</tr>
             </thead>
             <tbody>
					@if(!$mylikes->isEmpty())
						@foreach($mylikes as $key => $mlike)
						 <tr>

							<td>
								 <div class="contnt-box btn">
								 <h5><a href="{{ url('view-opportunity', Crypt::encrypt($mlike->id)) }}">{{ $mlike->opportunity }}</a></h5>
								 <h6>
									@foreach(explode(',', $mlike->focus_areas) as  $focus_area)
										{{ $loop->first ? '' : ', ' }}
										{{$focus_areas[$focus_area]}}
									@endforeach
								 </h6>
                 
								 </div>
							</td>
							<td class="text-left"> {{ $mlike->opp_manager }}</td>
							<td class="text-left"> {{ date('m-d-y', strtotime($mlike->start_date)) }}</td>
							<td class="text-left"> {{ date('m-d-y', strtotime($mlike->end_date)) }}</td>
							<td>  
								<div class="oppor-detail for-like">
                   <a href=" {{ url('opportunity/not_like', Crypt::encrypt($mlike->id)) }}"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
								  </div>
							</td>
							
						 </tr>
						 @endforeach
				
					@else
						<tr>
							<td colspan="4">
								<div class="contnt-box btn">
								<h5>No opportunities for you!</h5>
							</td>
						</tr>
					@endif
				</tbody>
             </table>
             <?php /*   
            <div class="inner-pages row clearfix inner-oppor-headings-wrapper">
              <div class="col-md-6">
                <div class="for-mrgn for-oppor-margn">
                  Favorites:
                </div>
              </div>
              <div class="col-md-2">
                <div class="oppor-detail for-favorite">
                  Start:
                </div>
              </div>
              <div class="col-md-2">
                <div class="oppor-detail for-favorite">
                  End:
                </div>
              </div>
              <div class="col-md-2">
                <div class="oppor-detail for-oppor-margn for-favorite">
                  Edit:
                </div>
              </div>
            </div>
          
        </div>
        <!-- <div class="col-md-12"> -->
         <div class="main-cntnt-inner main-wrapper">
          @if(!$myfavorites->isEmpty())
            @foreach($myfavorites as $key => $myfavorite)
              <div class="oppor-detail-data row clearfix">
                <div class="col-md-6" data-toggle="modal" data-target="#myoppoModal___{{$myfavorite->id}}" id="myopp-one-{{$myfavorite->id}}">
                  <div class="pic-box for-mrgn">
                    <img src="{{ URL::asset('images/green-square.png') }}" class="side-pic" />
                  </div>
                  <div class="contnt-box btn ">
                    <h6>Merchandising</h6>
                    <h5>{{$myfavorite->opportunity}}</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="oppor-detail for-favorite">
                    {{ date('m/d/Y', strtotime($myfavorite->start_date)) }}
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="oppor-detail for-favorite">
                    {{ date('m/d/Y', strtotime($myfavorite->end_date)) }}
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="oppor-detail for-favorite">
                   <i class="fa fa-heart" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="myoppoModal{{$myfavorite->id}}">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content row clearfix">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body row clearfix">
                      <div class="col-md-2" style="visibility: hidden;"></div>
                      <div class="col-md-4 null-padng-right">
                        <div class="modal-left-section for-gree-colr">
                          <div class="awsm-icon">
                             @if($myfavorite->like == 0)
                              <a title="{{ __('Like') }}" href="{{ url('opportunity/like', Crypt::encrypt($myfavorite->id)) }}"><i class="fa fa-thumbs-up"></i></a>
                            @else
                              <i class="fa fa-thumbs-up active"></i>
                            @endif
                          </div>
                          <div class="modal-card-hdng">
                            <h6>Merchandising</h6>
                            <h4>{{$myfavorite->opportunity}}</h4>
                          </div>
                          <div class="modal-date-section">
                            <div class="modal-card-date"><span>Start: </span>{{ date('m/d/Y', strtotime($myfavorite->start_date)) }}</div>
                            <div class="modal-card-date"><span>End: </span> {{ date('m/d/Y', strtotime($myfavorite->end_date)) }}</div>
                          </div>
                          @if($myfavorite->apply == 0)
                          <a class="btn modal-card-btn with-blackbg" title="{{ __('Apply') }}" href="{{ url('opportunity/apply', Crypt::encrypt($myfavorite->id)) }}">{{ __('Apply') }}</a>
                          <div class="apply-before-text">
                            Apply before:  {{ date('m/d/Y', strtotime($myfavorite->end_date)) }}
                          </div>
                          @else
                          <button class="btn modal-card-btn with-blackbg">Applied</button>
                          @endif

                        </div>
                      </div>
                      <div class="col-md-6 null-padng-left">
                        <div class="modal-rite-section">
                          <h6>Opportunity Summary</h6>
                          <p class="txt-cntnt"> 
                            {{$myfavorite->opportunity_desc}}
                          </p>
                          @if($myfavorite->rewards)
                            <div class="green-clr reward-section">
                              <h6>Reward</h6>
                              <p class="txt-cntnt"> {{$myfavorite->rewards}}</p>
                            </div>
                          @endif
                          @isset($myfavorite->skills)
                            <h6>Skills</h6>
                            <p class="txt-cntnt">
                            @foreach(explode(',', $myfavorite->skills) as $skill) 
                              {{ $loop->first ? '' : ', ' }}
                              {{$skills[$skill]}}
                            @endforeach
                          </p>
                          @endif
                          @isset($myfavorite->focus_areas)
                            <h6>Focus Areas</h6>
                            <p class="txt-cntnt">
                              @foreach(explode(',', $myfavorite->focus_areas) as  $focus_area)
                                {{ $loop->first ? '' : ', ' }}
                                {{$focus_areas[$focus_area]}}
                              @endforeach
                            </p>
                          @endisset
                        </div>
                      </div>
                      <div class="col-md-2"  style="visibility: hidden;"></div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            @if( method_exists($myfavorites,'links') )
               {{  $myfavorites ->links() }}
            @endif
          @else
            <p>You haven't marked any favorite yet.<p>
          @endif
        </div> */ ?>
        <!-- </div> -->
      </div>
      <!-- </div> -->
    </div>
  </div>
</div>
</section>
@endsection
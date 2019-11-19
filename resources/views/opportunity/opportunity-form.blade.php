@extends('layouts.admin')
@section('content')  
@include('common.admin-nav') 

<section class="main-body" id="inner-profile-page">
  <div class="container">
    <div class="row clearfix">
     
      <div class="col-md-12">
        <form method="POST" action="{{$opportunity_form_action}}" class="row clearfix" id="create-opportunity-form">
          <div class="col-md-6">
              <h1 class="inner-page-heading">
                {{$opportunity_page_title }}
              </h1>
          </div>
          <div class="col-md-6">
            <div class="update-oppr-right-sec">
              <div class="opp-status-lbl"><i>{{ (!empty($opportunity_data)) ? get_opp_status_label( $opportunity_data->status) : '' }}</i></div>
            </div>
          </div>
      <hr class="for-form-brdr">   
          @csrf
          <div class="col-md-8">
            <div class="form-group clearfix">
              <label for="opportunity">{{ __('Title of opportunity') }}</label>
			  
			   <input id="opportunity" type="text" class="form-control @error('opportunity') is-invalid @enderror" name="opportunity" value="{{  old('opportunity', @$opportunity_data->opportunity) }}" autocomplete="opportunity" autofocus>
			  
              @error('opportunity')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group clearfix">
                <label>Manager</label>
                <select class="js-example-basic-multiple form-control @error('org_uid') is-invalid @enderror" name="org_uid"  >
                <option value="">-- Choose Manager--</option>
                @foreach ($managers as $manage)
                <option value="{{ $manage->id }}" {{ ($opportunity_page_action=='add') ? (($manage->id==auth()->user()->id) ? "selected" : "") : (($manage->id==old('org_uid', @$opportunity_data->org_uid)) ? "selected" : "") }}>{{ $manage->mname }}</option>
                @endforeach 							  
              </select>
              @error('org_uid')
              <span class="invalid-feedback" role="alert">
                 <strong>Manager field is required.</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group clearfix" id="start-date-calendar">
              <label for="start_date">{{ __('Start Date:') }}</label>
              <div class="input-group date" id="id_4">
                
                <input id="start_date" type="text" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ !empty(old('start_date', @$opportunity_data->start_date)) ?  date('m/d/Y', strtotime(old('start_date', @$opportunity_data->start_date))) : '' }}"  autocomplete="start_date" autofocus />
				
                <div class="input-group-addon input-group-append">
                  <div class="input-group-text">
                  <i class="fas fa-calendar-alt"></i>
                  </div>
                 </div>
				  
                <div class="date-btm-txt">{{ !empty(old('start_date', @$opportunity_data->start_date)) ?  date('m/d/Y', strtotime(old('start_date', @$opportunity_data->start_date))) : '' }}</div>                
                @error('start_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
          </div>


         

            <div class="col-md-4">
              <div class="form-group clearfix" id="apply-date-calendar">
                <label for="apply_before">{{ __('Apply Before:') }}</label>
                <div class="input-group date" id="id_6">
                  <input id="apply_before" type="text" class="form-control @error('apply_before') is-invalid @enderror" name="apply_before" value="{{   !empty(old('apply_before', @$opportunity_data->apply_before)) ? date('m/d/Y', strtotime(old('apply_before', @$opportunity_data->apply_before))) : '' }}"  autocomplete="apply_before" autofocus />
                  <div class="input-group-addon input-group-append">
                    <div class="input-group-text">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                    </div>
                  </div>
				  <div class="date-btm-txt">{{  !empty(old('apply_before', @$opportunity_data->apply_before)) ?  date('m/d/Y', strtotime(old('apply_before', @$opportunity_data->apply_before))) : ''}}</div>
				  
                  @error('apply_before')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
          </div>

          <div class="col-md-4">
              <div class="form-group clearfix" id="end-date-calendar">
                <label for="end_date">{{ __('End Date:') }}</label>
                <div class="input-group date" id="id_5">
                  <input id="end_date" type="text" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ !empty(old('end_date', @$opportunity_data->end_date)) ? date('m/d/Y', strtotime(old('end_date', @$opportunity_data->end_date))) : '' }}"  autocomplete="end_date" autofocus />
                  <div class="input-group-addon input-group-append">
                    <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                    </div>
                  </div>
                  <div class="date-btm-txt">{{ !empty(old('end_date', @$opportunity_data->end_date)) ? date('m/d/Y', strtotime(old('end_date', @$opportunity_data->end_date))) : '' }}</div>
                  @error('end_date')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              </div>

          <div class="col-md-6">
              <div class="form-pillbox form-group clearfix">
				  <label for="skills">{{ __('Skills') }}</label>
				  <select class="js-example-basic-multiple form-control @if ($errors->has('skills')) is-invalid  @endif " id="skills" name="skills[]" multiple="multiple">
          @foreach($skill_options as $skill_option)
          @php
          $skills_exists =  old('skills', explode(',',@$opportunity_data->skills));
          @endphp
					 <option 
						  @if(in_array($skill_option->tid, $skills_exists))
							selected="selected"
						  @endif 
					   value="{{$skill_option->tid}}">{{$skill_option->name}}
					 </option>
					@endforeach
				  </select>
				   @if ($errors->has('skills'))
              <span class="input-error-msg">
                  <strong>You must select at least one skill.</strong>
              </span>
             @endif 
			  
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-pillbox form-group clearfix">
             <label for="focus_area">{{ __('Focus Area') }}</label>
               <select class="js-example-basic-multiple form-control @if ($errors->has('focus_area'))  is-invalid  @endif " id="focus_area" name="focus_area[]" multiple="multiple">
                  @foreach($focus_area_options as $focus_area_option)
                  
                  @php
                  $focus_areas_exists =  old('focus_area', explode(',',@$opportunity_data->focus_areas));
                 @endphp
                  <option 
                      @if(in_array($focus_area_option->tid, $focus_areas_exists))
                        selected="selected"
                      @endif
                    value="{{$focus_area_option->tid}}">{{$focus_area_option->name}}
                  </option>
                  @endforeach
                </select>
                 @if ($errors->has('focus_area'))
              <span class="input-error-msg">
                  <strong>You must select at least one focus area.</strong>
              </span>
             @endif 
            </div>
          </div>

          <div class="col-md-12">

            <div class="form-pillbox form-group clearfix">
             <label for="locations">{{ __('Locations') }}</label>
               <select class="js-example-basic-multiple form-control @if ($errors->has('locations'))  is-invalid  @endif " id="locations" name="locations[]" multiple="multiple">
                  @foreach($location_options as $location_option)
                  @php
                        $locations_exists =  old('locations', explode(',',@$opportunity_data->locations));
                      @endphp
                  <option 
                      
                      @if(in_array($location_option->tid, $locations_exists))
                        selected="selected"
                      @endif
                    value="{{$location_option->tid}}">{{$location_option->name}}
                  </option>
                  @endforeach
                </select>
                 @if ($errors->has('locations'))
              <span class="input-error-msg">
                  <strong>You must select at least one location.</strong>
              </span>
             @endif 
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group clearfix">
              <label for="opportunity_desc">{{ __('Description of opportunity') }}</label>
              <textarea rows="4", cols="54" 
              id="opportunity_desc" class="form-control @error('opportunity_desc') is-invalid @enderror char-limit"  
              name="opportunity_desc" 
              placeholder="The UX-UI Designers will be responsible for collecting, researching, investigating and evaluating user requirements. Their responsibility is to deliver an outstanding user experience providing an exceptional and intuitive application design." 
              autofocus style="resize:none, " data-char-limit="1000">{{ isset($opportunity_data->opportunity_desc) ? $opportunity_data->opportunity_desc : old('opportunity_desc') }}</textarea>
              <div class="char-limit-text"></div>
              @error('opportunity_desc')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group clearfix">
			  
			  <label for="rewards">{{ __('Rewards for applying') }}</label>
              <textarea rows="3", cols="54" id="rewards" class="form-control @error('rewards') is-invalid @enderror char-limit"  name="rewards" autofocus style="resize:none, " data-char-limit="200">{{ isset($opportunity_data->rewards) ? $opportunity_data->rewards : old('rewards') }}</textarea>
              <div class="char-limit-text"></div>
              @error('rewards')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
              </span>
              @enderror
			  
            </div>
          </div>
          
         
         
       
        <div class="container">
            <div class="row clearfix">
              <div class="col-md-12">
                <div class="form-btns clearfix">
                  <div class="form-btns profile-btns clearfix">        
                  <button type="submit" class="cmmn-btn save-btn profile-btn" name="submit" value="publish">{{ __('Publish') }}</button>
                  <button type="submit" class="cmmn-btn save-btn profile-btn" name="submit" value="draft">{{ __('Save As Draft')}}</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
		 </form>
      </div>
    </div>
  </div>
</section>
	<!---Content Closed-->
@endsection
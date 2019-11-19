@extends('layouts.app')
@section('content')   
<section class="main-body" id="org-form">
  <div class="container">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="back-btn">
          <a href="{{ route('organizations') }}"><i class="fa fa-long-arrow-left"></i>{{ __('Back') }}</a>
        </div>
      </div>
      <div class="col-md-12">
        <h1 class="inner-page-heading">{{ $org_page_title }}</h1>
      </div>
      <div class="col-md-12">
        <form method="POST" action="{{$org_form_action}}" class="row clearfix" id="create-organization-form">
          @csrf
          <div class="col-md-6">
            <div class="form-group clearfix">
              <label for="name">{{ __('Organization Name') }}</label>
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($org_data->name) ? $org_data->name : old('name') }}" autocomplete="name" autofocus>
              @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
		  
		   <div class="col-md-6">
            <div class="form-group clearfix">
              <label for="street">{{ __('Street') }}</label>
              <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ isset($org_data->street) ? $org_data->street : old('street') }}" autocomplete="street" autofocus>
              @error('street')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
		  
		  <div class="col-md-6">
            <div class="form-pillbox form-group clearfix" id="organization-city">
              <label for="city">{{ __('City') }}</label>
			  <select  class="js-example-basic-multiple @error('city') is-invalid @enderror " name="city" >
					<option value="">Choose City</option>	
					@foreach ($cities_list as $dcity)
						<option value="{{ $dcity->id }}" {{ (isset($org_data->city) && $dcity->id == $org_data->city ) ? "selected" : "" }}>{{ $dcity->city_name }}</option>
					@endforeach
              </select>
              <!--input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ isset($org_data->city) ? $org_data->city : old('city') }}" autocomplete="city" autofocus-->
			  
              @error('city')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
		  
		   <div class="col-md-6">
            <div class="form-group clearfix">
              <label for="state">{{ __('State') }}</label>
			  <select class="js-example-basic-multiple @error('state') is-invalid @enderror" name="state">
					<option value="">Choose State</option>
				@foreach ($states_list as $dstate)
					<option value="{{ $dstate->id }}" {{ (isset($org_data->state) && $dstate->id==$org_data->state) ? "selected" : "" }}>{{ $dstate->state_name }}</option>
				@endforeach
			  </select>
              <!--input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ isset($org_data->state) ? $org_data->state : old('state') }}" autocomplete="state" autofocus-->
              @error('state')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
	
         
		 <div class="col-md-6">								
			<div class="form-group clearfix">
				<label for="phone">{{ __('Phone') }}</label>
				<div class="col-md-12">
				  <div class="row clearfix">
						<div class="col-md-2 null-padng-left">
								<input class="form-control @error('country_code') is-invalid @enderror" type="tel" value="{{ isset($org_data->country_code) ? $org_data->country_code : old('country_code') }}" id="tel-input" name="country_code">
								@error('country_code')
								  <span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								  </span>
								@enderror
						</div>
						<div class="col-md-10 null-padng-left">
							 <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ isset($org_data->phone) ? $org_data->phone : old('phone') }}" autocomplete="phone" autofocus>
							@error('phone')
							  <span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							  </span>
							@enderror
						</div>
				  </div>
				</div>										
			</div>																
		</div>
      
		  
		   <div class="col-md-6">
            <div class="form-group clearfix">
              <label for="director">{{ __('Director') }}</label>
              <input id="director" type="text" class="form-control @error('director') is-invalid @enderror" name="director" value="{{ isset($org_data->director) ? $org_data->director : old('director') }}" autocomplete="director" autofocus>
              @error('director')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
     
          <div class="col-md-12">
            <div class="form-group clearfix">
              <label for="notes">{{ __('Notes') }}</label>
              <textarea rows="4", cols="54" id="notes" class="form-control @error('notes') is-invalid @enderror"  name="notes" autofocus style="resize:none, ">{{ isset($org_data->notes) ? $org_data->notes : old('notes') }}</textarea>
              @error('notes')
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
                  <button type="submit" class="cmmn-btn edit-btn create-opportunity">{{ __('Create Organization') }}</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
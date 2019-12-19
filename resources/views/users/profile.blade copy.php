@extends('layouts.admin')
@section('content')  
@include('common.admin-nav') 
<section class="main-body" id="inner-profile-page">
  <div class="container">
    <div class="row clearfix">
      <div class="col-md-12">
        <form class="row clearfix" action="{{ ($action_type=='SELF-EDIT' ? route('update') : url('update', Crypt::encrypt(old('id', @$users->id)))) }}" method="post">
          <div class="col-md-12">
            <h2 class="profile-heading">Profile</h2>
          </div>
          <hr class="for-form-brdr">          
          @csrf
          <div class="col-md-6">
            <div class="form-group clearfix">
              <label for="name">Name *</label>
              <input type="name" class="form-control  @error('firstname') is-invalid @enderror" value="{{  old('firstname', @$users->firstName) }}" id="name" placeholder="Enter name" name="firstname">
			  
			       @error('firstname')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group clearfix">
              <label for="availability">Availability *</label>
              <input type="availability" class="form-control @error('availability') is-invalid @enderror" id="availability" placeholder="Available hours per month" name="availability" value="{{  old('availability', @$users->availability) }}">
			  
			     @error('availability')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div> 
          @if(in_array(config('kloves.ROLE_ADMIN'),explode(",",Auth::user()->roles)) )
           <input type='hidden' name="manager" value="{{ (!empty($users->manager_id) || old('manager') != null) ? old('manager', @$users->manager_id) : Auth::user()->id }}">
          @else
          <div class="col-md-6">
            <div class="form-pillbox form-group clearfix">
              <label>Manager *</label>
                <select class="js-example-basic-multiple form-control @error('manager') is-invalid @enderror" name="manager"  >
                <option value="">-- Choose Manager--</option>
                @foreach ($managers as $manage)
                <option value="{{ $manage->id }}" {{ ($manage->id==old('manager', @$users->manager_id)) ? "selected" : "" }}>{{ $manage->mname }}</option>
                @endforeach 							  
              </select>

              @error('manager')
              <span class="invalid-feedback" role="alert">
                <strong>Manager field is required.</strong>
              </span>
              @enderror
            </div>
          </div>
          @endif
          <div class="col-md-6">
            <div class="form-group clearfix">
              <label for="aspirations">Aspirations</label>
              <input type="aspirations" class="form-control" id="aspirations" placeholder="Aspirations" name="aspirations" value="{{  old('aspirations', @$users->aspirations) }}">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-pillbox clearfix">
              <label>Focus Area *</label>
              <select class="js-example-basic-multiple  @if ($errors->has('focus'))  is-invalid  @endif " name="focus[]" multiple="multiple">
              @foreach ($focus as $foc)
              <option value="{{ $foc->tid }}" {{ (in_array($foc->tid, old('focus', explode(',', @$users->focus)))) ? "selected" : "" }}>{{ $foc->name }}</option>
              @endforeach 							  
              </select>

              @if ($errors->has('focus'))
              <span class="input-error-msg">
                  <strong>You must select at least one focus area.</strong>
              </span>
             @endif 
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-pillbox clearfix">
              <label>Skills *</label>
              <select class="js-example-basic-multiple  @if ($errors->has('skills')) is-invalid  @endif " name="skills[]" multiple="multiple">
              @foreach ($skills as $skill)
              <option value="{{ $skill->tid }}" {{ (in_array($skill->tid, old('skills', explode(',', @$users->skills)))) ? "selected" : "" }}>{{ $skill->name }}</option>
              @endforeach 									  			
              </select>

              
              @if ($errors->has('skills'))
              <span class="input-error-msg">
                  <strong>You must select at least one skill.</strong>
              </span>
             @endif 
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group clearfix" id="comment-view">
              <label for="comment">Tell us about yourself</label>
			  <p>{{ isset($users->notes) ? $users->notes : (old('notes') ? old('notes') : 'NA') }}</p>
            </div>
			<div class="d-none" id="comment-edit">
              <textarea class="form-control char-limit" rows="5" id="comment" placeholder="Take high-level requirements and translate them into simple business solutions. A self-starter;team player that operates in groups as well as independently UX/UI Design Art Direction Collaborator Front-end Development" name="notes" data-char-limit="500">{{ isset($users->notes) ? $users->notes : old('notes') }}</textarea>
				<div class="char-limit-text"></div>
            </div>
			<a href="#">Edit</a>
          </div>
      </div>
    </div>
  </div>
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-12">
			  <div class="form-btns profile-btns clearfix">
				@if(str_replace(url('/'), '', url()->previous())=='/login' && (empty($users->manager_id)))
				<button type="submit" class="cmmn-btn save-btn profile-btn">Update</button>
				 @else
				<button type="submit" class="cmmn-btn edit-btn profile-edit-btn">Update</button> 
				@endif   
			  </div>
			</div>
		</div>
	</div>
  </form>		
</section>
	<!---Content Closed-->
	

@endsection

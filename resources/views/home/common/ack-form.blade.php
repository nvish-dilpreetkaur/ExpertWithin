<form id="acknowledgeForm" method="post"  action="{{ route('acknowledge') }}" class="needs-validation" novalidate>
      <div class="form-group">
            <div class="to-cmbine-the-label-txt">
                  <label for="uname">Who do you want to recognize?</label>
                  <!--input type="text" class="form-control" id="uname" placeholder="Sonny Fernandez" name="uname" required>-->
                  <select class="js-example-basic-multiple form-control" name="user_id"  id="user_id">
                              <option value="">-- Choose --</option>
                              @foreach ($all_users as $urow)
                              <option value="{{ $urow->id }}" {{ ($urow->id==old('user_id')) ? "selected" : "" }}>{{ $urow->firstName }}</option>
                              @endforeach 							  
                  </select>
            </div>						 
        <div class="valid-feedback">Valid.</div>
        <div class="invalid-feedback"  id="error-user_id"></div>
      </div>
      <div class="form-group">
        <div class="to-cmbine-the-label-txt">
              <label for="desc">Tell us why?</label>
              <textarea placeholder="Sonny provided a lot of great design workand worked well with others. He can fit into any team environment with ease and provide extraordinary results very quickly!" rows="4" cols="50" name="message" class="form-control" id="message" required></textarea>		
        </div> 
        <div class="valid-feedback">Valid.</div>
        <div class="invalid-feedback" id="error-message"></div>
      </div>
      <div class="form-group form-check">
      </div>
      <div class="main-page__form-buttons">
            <button type="submit" class="btn btn-primary">Acknowledge</button>
      </div>
  </form>
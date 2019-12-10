@extends('layouts.app')
@section('content')
      <div class="container">
        <div class="row clearfix">
          <div class="main-contnt-body" id="create__opportunity-page">
              <div class="container">
            <div class="row">
              <!--LEFT-SECTION-->
              <!-- <div class="col-md-4 col-lg-4 main-page__left-section--outer"> -->
              <div>
                <div class="fixme">
                </div>
              </div>
              <!--LEFT-SECTION-END-->
              <!--MIDDLE-SCROLL-SECTION-->
              <div class="col-md-8 col-lg-8 main-page__middle-section--outer">
                <div class="middle-scroll-section__outer">
                  <div class="step-slider-create-oppor">
                    <div class="center">
                      <div class="for-step-bar__titles">
                        <!-- Step progress bar -->
                        <ul class="step-progress-bar">
                          <li class="step-item current"><a href="#">Draft</a></li>
                          <li class="step-item"><a href="#">Publish</a></li>
                          <li class="step-item"><a href="#">Screen</a></li>
                          <li class="step-item"><a href="#">Complete</a></li>
                          <li class="step-item"><a href="#">Cancel</a></li>
                        </ul>
                      </div>

                      <div class="slides-container">
                        <div class="card slide current-slide">
                          <div class="card-header">
                            <div class="form-slides-container__header">
                              <button id="btn-opr-u-save" type="button" class="create-oppor-hdr-cmmn-btn">
                              <span>Save (⌘+S )</span>
                              </button>
                              <button id="btn-opr-u-publish" type="button" class="create-oppor-hdr-cmmn-btn">
                              <span>Publish</span>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <form action="#" id="opportunity-store" class="needs-validation form-create-opportunity" novalidate>
                              <div class="form-group">
                                <label for="otitle">Title</label>
                                <input type="hidden" class="form-control" id="oid" name="oid" value="{{$opportunity->id}}">
                                <input type="text" class="form-control" id="otitle" placeholder="Email and social media specialist (E-Commerce)" name="otitle" value="{{$opportunity->opportunity}}" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                              </div>
                              <div class="row">
                                <div class="col-md-6 create-oppor-form__coin-counter">
                                    <div class="form-group">
                                        <label for="oexperts">How many experts do you need for this opportunity?</label>
                                        <div class="number experts">
                                        <span class="plus">+</span>
                                        <input type="text" class="form-control" id="oexperts" placeholder="" name="oexperts" value="{{ ($opportunity->expert_qty>0)?$opportunity->expert_qty:1 }}" required>
                                        <span class="minus">-</span>
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group" id="create-oppor-dates">
                                    <div class="input-group date" id="startDate">
                                      <label for="start_dm">Start Date</label>
                                      <input type="text" class="form-control" id="start_dm" name="start_dm" value="{{ date_format(date_create($opportunity->start_date),'m/d') }}">
                                      <span class="input-group-addon">
                                      <i class="fas fa-calendar-alt"></i>
                                      </span>
                                    </div>
                                    <div class="create-oppor-dates__selected" id="start_date_frmt">{{ date_format(date_create($opportunity->start_date),"D, M d, Y") }}</div>
                                    <input type="hidden" id="start_date" name="start_date" value="{{ date_format(date_create($opportunity->start_date),'Y-m-d H:i:s') }}">
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group" id="create-oppor-dates">
                                    <div class="input-group date" id="endDate">
                                      <label for="end_dm">End Date</label>
                                      <input type="text" class="form-control" id="end_dm" name="end_dm" value="{{ date_format(date_create($opportunity->end_date),'m/d') }}">
                                      <span class="input-group-addon">
                                      <i class="fas fa-calendar-alt"></i>
                                      </span>
                                    </div>
                                    <div class="create-oppor-dates__selected" id="end_date_frmt">{{ date_format(date_create($opportunity->end_date),"D, M d, Y") }}</div>
                                    <input type="hidden" id="end_date" name="end_date" value="{{ date_format(date_create($opportunity->end_date),'Y-m-d H:i:s') }}">
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group" id="create-oppor-dates">
                                    <div class="input-group date" id="applyBefore">
                                      <label for="apply_dm">Apply Before</label>
                                      <input type="text" class="form-control" id="apply_dm" name="apply_dm" value="{{ date_format(date_create($opportunity->apply_before),'m/d') }}">
                                      <span class="input-group-addon">
                                      <i class="fas fa-calendar-alt"></i>
                                      </span>
                                    </div>
                                    <div class="create-oppor-dates__selected" id="apply_before_frmt">{{ date_format(date_create($opportunity->apply_before),"D, M d, Y") }}</div>
                                    <input type="hidden" id="apply_before" name="apply_before" value="{{ date_format(date_create($opportunity->apply_before),'Y-m-d H:i:s') }}">
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="odesc">Summary</label>
                                <textarea class="form-control" rows="3" id="odesc" name="odesc" placeholder="Focused on the delivery of relevant and content-rich emails and posts.">{{ $opportunity->opportunity_desc }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                              </div>
                              <div class="form-group">
                                <label for="incentives">What are the incentives?</label>
                                <textarea class="form-control" rows="4" id="incentives" name="incentives" placeholder="Kloves research is developing a proof-of-concept prototype, and will evaluate end-to-end system performance. Gain industry skills in this project.">{{ $opportunity->incentives }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                              </div>
                              <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rewards">Rewards</label>
                                    <input type="text" class="form-control" id="rewards" placeholder="$150 Gift Card" name="rewards" value="{{ $opportunity->rewards }}" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tokens">How many tokens?</label>
                                    <div class="create-oppor-form__coin-counter">
                                    <i class="fas fa-coins gold-coins-color" aria-hidden="true"></i>
                                    <div class="number">
                                        <span class="plus">+</span>
                                        <input type="text" name="tokens" id="tokens" value="{{ ($opportunity->tokens>0)?$opportunity->tokens:1 }}" class="form-control">
                                        <span class="minus">-</span>
                                    </div>
                                    </div>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                </div>
                              </div>
                              <div class="form-pillbox form-group create-opportunity__pills-dropdown create-opportunity__pills-dropdown--for-skills clearfix">
                                <label>Skills</label>
                                <select class="multiple-pills-dropdown custom-select" id="skills" name="skills[]" multiple="multiple">
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill->tid }}" {{ (in_array($skill->tid, $selectedSkills))?"selected":"" }}>{{ $skill->name }}</option>
                                @endforeach
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                              </div>
                              <div class="form-pillbox form-group create-opportunity__pills-dropdown create-opportunity__pills-dropdown--for-focus-area clearfix">
                                <label>Focus Area</label>
                                <select class="multiple-pills-dropdown custom-select" id="focus_area" name="focus_area[]" multiple="multiple">
                                @foreach ($focusArea as $focusAr)
                                    <option value="{{ $focusAr->tid }}" {{ (in_array($focusAr->tid, $selectedFocusAr))?"selected":"" }}>{{ $focusAr->name }}</option>
                                @endforeach
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                              </div>
                            </form>
                          </div>
                          <!----first-crad-body-END-->
                          <div class="form-slides-container__footer">
                            <button id="btn-opr-save" type="button" class="create-oppor-hdr-cmmn-btn">
                            <span>Save (⌘+S )</span>
                            </button>
                            <button id="btn-opr-publish" type="button" class="create-oppor-hdr-cmmn-btn">
                            <span>Publish</span>
                            </button>
                          </div>
                        </div>
                        <!----------SECOND-CARD-START----->
                        <div class="card slide">
                          <div class="card-header">
                            <div class="form-slides-container__header">
                              <button id="prev-button-up" type="button" class="create-oppor-hdr-cmmn-btn for-left-btn-cmmn">
                              <span>Send back to draft</span>
                              </button>
                              <button id="#" type="button" class="create-oppor-hdr-cmmn-btn">
                              <span>Cancel</span>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <p class="blue-highlit-txt"> Rewards: <span id="publish__reward">{{$opportunity->rewards}}</span></p>
                            <div class="create-opportunity__form-details-main-heading">
                              Email and social media specialist (Marketing)
                            </div>
                            <div class="create-opportunity__form-details-sub-headings">
                              <ul>
                                <li>Est start: <span id="publish__start_date">{{ date_format(date_create($opportunity->start_date),"M d, Y") }}</span></li>
                                <li>Est end: <span id="publish__end_date">{{ date_format(date_create($opportunity->end_date),"M d, Y") }}</span></li>
                              </ul>
                            </div>
                            <div class="create-opportunity__form-details-sub-headings">
                              <ul>
                                <li class="create-opportunity__form--coins-count"><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span id="publish__tokens">{{$opportunity->tokens}}</span></li>
                                <li>Last day to apply: <span id="publish__apply_before">{{ date_format(date_create($opportunity->apply_before),"M d, Y") }}</span></li>
                              </ul>
                            </div>
                            <div class="create-opportunity__form-details-cmmn-headings">
                              Description
                            </div>
                            <div class="create-opportunity__form-details-cmmn-content" id="publish__opportunity_desc">
                              {{$opportunity->opportunity_desc}}
                            </div>
                            <div class="create-opportunity__form-details-cmmn-headings">
                              What are the incentives?
                            </div>
                            <div class="create-opportunity__form-details-cmmn-content" id="publish__incentives">
                            {{$opportunity->incentives}}
                            </div>
                            <div class="create-opportunity__form-details-cmmn-headings">
                              Skills
                            </div>
                            <div class="create-opportunity__form-details-cmmn-content">
                              <ul id="publish__skills">
                              @foreach ($skills as $skill)
                                <?=(in_array($skill->tid, $selectedSkills))?"<li>$skill->name</li>":""?>
                              @endforeach
                              </ul>
                            </div>
                            <div class="create-opportunity__form-details-cmmn-headings">
                              Focus Area
                            </div>
                            <div class="create-opportunity__form-details-cmmn-content">
                              <ul id="publish__focus_area">
                              @foreach ($focusArea as $focusAr)
                                <?=(in_array($focusAr->tid, $selectedFocusAr))?"<li>$focusAr->name</li>":""?>
                              @endforeach
                              </ul>
                            </div>
                          </div>
                          <div class="form-slides-container__footer">
                            <button id="prev-button" type="button" class="create-oppor-hdr-cmmn-btn for-left-btn-cmmn">
                            <span>Send back to draft</span>
                            </button>
                            <button id="#" type="button" class="create-oppor-hdr-cmmn-btn">
                            <span>Cancel</span>
                            </button>
                          </div>
                        </div>
                        <!----------THIRD-CARD-START------>
                        <div class="card slide create-opportunity__oppor-detail--candidates-outer">
                          <!-- <div class="card-header"></div> -->
                          <div class="tile" id="tile-1">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                              <div class="slider"></div>
                              <li class="nav-item">

                                <a class="nav-link active" id="opportunity-detail-tab" data-toggle="tab" href="#opportunityDetail" role="tab" aria-controls="home" aria-selected="true">Opportunity detail</a>
                              </li>
                              <li class="nav-item">

                                <a class="nav-link" id="candidates-tab" data-toggle="tab" href="#candidates" role="tab" aria-controls="candidates" aria-selected="false"> Candidates</a>
                              </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                              <div class="tab-pane fade show active" id="opportunityDetail"
                                role="tabpanel" aria-labelledby="opportunity-detail-tab">
                                <p class="blue-highlit-txt"> Rewards: <span id="screen__reward">{{$opportunity->rewards}}</span></p>
                                <div class="create-opportunity__form-details-main-heading">
                                  Email and social media specialist (Marketing)
                                </div>
                                <div class="create-opportunity__form-details-sub-headings">
                                <ul>
                                    <li>Est start: <span id="screen__start_date">{{ date_format(date_create($opportunity->start_date),"M d, Y") }}</span></li>
                                    <li>Est end: <span id="screen__end_date">{{ date_format(date_create($opportunity->end_date),"M d, Y") }}</span></li>
                                </ul>
                                </div>
                                <div class="create-opportunity__form-details-sub-headings">
                                <ul>
                                <li class="create-opportunity__form--coins-count"><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span id="screen__tokens">{{$opportunity->tokens}}</span></li>
                                <li>Last day to apply: <span id="screen__apply_before">{{ date_format(date_create($opportunity->apply_before),"M d, Y") }}</span></li>
                              </ul>
                                </div>
                                <div class="create-opportunity__form-details-cmmn-headings">
                                  Description
                                </div>
                                <div class="create-opportunity__form-details-cmmn-content" id="screen__opportunity_desc">
                                    {{$opportunity->opportunity_desc}}
                                </div>
                                <div class="create-opportunity__form-details-cmmn-headings">
                                  What are the incentives?
                                </div>
                                <div class="create-opportunity__form-details-cmmn-content" id="screen__incentives">
                                    {{$opportunity->incentives}}
                                </div>
                                <div class="create-opportunity__form-details-cmmn-headings">
                                  Skills
                                </div>
                                <div class="create-opportunity__form-details-cmmn-content">
                                    <ul id="screen__skills">
                                    @foreach ($skills as $skill)
                                        <?=(in_array($skill->tid, $selectedSkills))?"<li>$skill->name</li>":""?>
                                    @endforeach
                                    </ul>
                                </div>
                                <div class="create-opportunity__form-details-cmmn-headings">
                                  Focus Area
                                </div>
                                <div class="create-opportunity__form-details-cmmn-content">
                                <ul id="screen__focus_area">
                                @foreach ($focusArea as $focusAr)
                                    <?=(in_array($focusAr->tid, $selectedFocusAr))?"<li>$focusAr->name</li>":""?>
                                @endforeach
                                </ul>
                                </div>
                              </div>
                              <div class="tab-pane fade" id="candidates" role="tabpanel" aria-labelledby="candidates-tab">
                              <div class="opportunity-details__candidates-applied">
                                <div class="opportunity-details__candidates-applied--user-details">
                                  <div class="opportunity-details__candidates-pic">
                                    <i class="fas fa-user-circle" aria-hidden="true"></i>
                                    <i class="fas fa-cubes user-pic__cube"></i>
                                  </div>
                                  <div class="opportunity-details__candidates-details">
                                    Alexis Smoody
                                  </div>
                                </div>
                                <div class="opportunity-details__candidates-applied--actions-list">
                                  <ul>
                                    <li><i class="far fa-check-circle"></i><a href="#">Approve</a></li>
                                    <li><i class="far fa-times-circle"></i><a href="#">Reject</a></li>
                                    <li><i class="far fa-comment-alt"></i><a href="#">Comment</a></li>
                                  </ul>
                                </div>
                              </div>
                              <!--------2nd candidate-->
                              <div class="opportunity-details__candidates-applied">
                                <div class="opportunity-details__candidates-applied--user-details">
                                  <div class="opportunity-details__candidates-pic">
                                    <i class="fas fa-user-circle" aria-hidden="true"></i>
                                    <i class="fas fa-cubes user-pic__cube"></i>
                                  </div>
                                  <div class="opportunity-details__candidates-details">
                                    Mark Terran
                                  </div>
                                </div>
                                <div class="opportunity-details__candidates-applied--actions-list">
                                  <ul>
                                    <li><i class="far fa-check-circle"></i><a href="#">Approve</a></li>
                                    <li><i class="far fa-times-circle"></i><a href="#">Reject</a></li>
                                    <li><i class="far fa-comment-alt"></i><a href="#">Comment</a></li>
                                  </ul>
                                </div>
                              </div>
                              <!--------3rd candidate-->
                              <div class="opportunity-details__candidates-applied">
                                <div class="opportunity-details__candidates-applied--user-details">
                                  <div class="opportunity-details__candidates-pic">
                                    <i class="fas fa-user-circle" aria-hidden="true"></i>
                                    <i class="fas fa-cubes user-pic__cube"></i>
                                  </div>
                                  <div class="opportunity-details__candidates-details">
                                    Samantha Fox
                                  </div>
                                </div>
                                <div class="opportunity-details__candidates-applied--actions-list">
                                  <ul>
                                    <li><i class="far fa-check-circle"></i><a href="#">Approve</a></li>
                                    <li><i class="far fa-times-circle"></i><a href="#">Reject</a></li>
                                    <li><i class="far fa-comment-alt"></i><a href="#">Comment</a></li>
                                  </ul>
                                </div>
                              </div>
                              <!--------4th candidate-->
                              <div class="opportunity-details__candidates-applied">
                                <div class="opportunity-details__candidates-applied--user-details">
                                  <div class="opportunity-details__candidates-pic">
                                    <i class="fas fa-user-circle" aria-hidden="true"></i>
                                    <i class="fas fa-cubes user-pic__cube"></i>
                                  </div>
                                  <div class="opportunity-details__candidates-details">
                                    Vincent Lawson
                                  </div>
                                </div>
                                <div class="opportunity-details__candidates-applied--actions-list">
                                  <ul>
                                    <li><i class="far fa-check-circle"></i><a href="#">Approve</a></li>
                                    <li><i class="far fa-times-circle"></i><a href="#">Reject</a></li>
                                    <li><i class="far fa-comment-alt"></i><a href="#">Comment</a></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-body"></div>
                        </div>
                        </div>
                        <!----------FOURTH-CARD-START------>
                        <div class="card slide">
                          <div class="card-header">Fourth Card Header</div>
                          <div class="card-body">Fourth Card Body</div>
                        </div>
                        <!----------FIFTH-CARD-START------>
                        <div class="card slide">
                          <div class="card-header">Fifth Card Header</div>
                          <div class="card-body">Fifth Card Body</div>
                        </div>
                      </div>
                      <!-- END slides -->
                    </div>
                  </div>
                </div>
              </div>
          <!--RIGHT-SECTION-->
          <div class="col-md-4 col-lg-4 main-page__right-section--outer">
            <div class="fixme-rite-sec">
                @if(!empty($myOppForCandidates))
                <div class="main-page__cmmn-card cmmn-card__-title-subtitle" id="opp-for-candidate">
                    @include('home.opp-for-candidate')
                </div>
                @endif
            </div>
          </div>
          <!--RIGHT-SECTION-END-->
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade main-page__cmmn_modal" id="opportunity__success">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
		  <div id="thanks_up" class="hidden"></div>
				<!-- Modal body -->
				<div class="modal-body text-center"><b>Opportunity Saved Successfully!</b></div>
		  </div>
		</div>
	  </div>

    <script>
    $(document).ready(function(){
        var oppr_status = "<?=$opportunity->status?>";
        if(oppr_status=="<?=config('kloves.RECORD_STATUS_ACTIVE')?>") {
            var current = $('.step-progress-bar').find('.current');
            var next = current.next(); 
            
            // Current to success
            current.removeClass('current');
            // Timeout giving time to the animation to render
            setTimeout(function() { current.addClass('success'); }, 0);
            
            // Disabled to current 
            if(next && next.length > 0) {
                next.addClass('current'); 
                nextSlideFncn();
            }
        }
        $( "button#btn-opr-save, button#btn-opr-publish, button#btn-opr-u-save, button#btn-opr-u-publish" ).on( "click", function() {
            var data_array = $("#opportunity-store").serializeArray();
            
            let btnVal = $(this).attr('id');
            if(btnVal=="btn-opr-publish" || btnVal=="btn-opr-u-publish") {
                data_array.push({name: 'status', value: 1});
            } else {
                data_array.push({name: 'status', value: 0});
            }

            $.ajax({
                type: "POST",
                url: SITE_URL+"/store-opportunity",
                data: data_array,
                success: function(data){
                    $('.invalid-feedback').hide();
                    if(data.status==false) {
                        $.each(data.message, function( index, value ) {
                            var error_elem =  $("#"+index).closest(".form-group").find(".invalid-feedback");
                            error_elem.show()
                            error_elem.text(value);
                        });
                    } else if(data.status==true) {
                        if(btnVal=="btn-opr-publish" || btnVal=="btn-opr-u-publish") {
                            /** Change Form Info Of Other Tabs */
                            /** Pubish Tab */
                            document.getElementById("publish__reward").innerHTML = data.opportunity.rewards;
                            document.getElementById("publish__start_date").innerHTML = data.opportunity.frmt_start_date;
                            document.getElementById("publish__end_date").innerHTML = data.opportunity.frmt_end_date;
                            document.getElementById("publish__apply_before").innerHTML = data.opportunity.frmt_apply_before;
                            document.getElementById("publish__tokens").innerHTML = data.opportunity.tokens;
                            document.getElementById("publish__opportunity_desc").innerHTML = data.opportunity.opportunity_desc;
                            document.getElementById("publish__incentives").innerHTML = data.opportunity.incentives;

                            let skillList = <?=json_encode($skills)?>;
                            var skillData = "";
                            $.each( skillList, function( key, value ) {
                                if(jQuery.inArray( value.tid.toString(), data.select_skills ) !== -1) {
                                    skillData+="<li>"+value.name+"</li>";
                                }
                            });
                            document.getElementById("publish__skills").innerHTML = skillData;

                            let focusAreaList = <?=json_encode($focusArea)?>;
                            var focusAreaData = "";
                            $.each( focusAreaList, function( key, value ) {
                                if(jQuery.inArray( value.tid.toString(), data.select_focus_area ) !== -1) {
                                    focusAreaData+="<li>"+value.name+"</li>";
                                }
                            });
                            document.getElementById("publish__focus_area").innerHTML = focusAreaData;

                            /** Screen Tab */
                            document.getElementById("screen__reward").innerHTML = data.opportunity.rewards;
                            document.getElementById("screen__start_date").innerHTML = data.opportunity.frmt_start_date;
                            document.getElementById("screen__end_date").innerHTML = data.opportunity.frmt_end_date;
                            document.getElementById("screen__apply_before").innerHTML = data.opportunity.frmt_apply_before;
                            document.getElementById("screen__tokens").innerHTML = data.opportunity.tokens;
                            document.getElementById("screen__opportunity_desc").innerHTML = data.opportunity.opportunity_desc;
                            document.getElementById("screen__incentives").innerHTML = data.opportunity.incentives;

                            var skillData = "";
                            $.each( skillList, function( key, value ) {
                                if(jQuery.inArray( value.tid.toString(), data.select_skills ) !== -1) {
                                    skillData+="<li>"+value.name+"</li>";
                                }
                            });
                            document.getElementById("screen__skills").innerHTML = skillData;

                            var focusAreaData = "";
                            $.each( focusAreaList, function( key, value ) {
                                if(jQuery.inArray( value.tid.toString(), data.select_focus_area ) !== -1) {
                                    focusAreaData+="<li>"+value.name+"</li>";
                                }
                            });
                            document.getElementById("screen__focus_area").innerHTML = focusAreaData;
                            /** Change Form Info Of Other Tabs Ends */

                            var current = $('.step-progress-bar').find('.current');
                            var next = current.next(); 
                            
                            // Current to success
                            current.removeClass('current');
                            // Timeout giving time to the animation to render
                            setTimeout(function() { current.addClass('success'); }, 0);
                            
                            // Disabled to current 
                            if(next && next.length > 0) {
                                next.addClass('current'); 
                                nextSlideFncn();
                            }
                        } else {
                            $('#opportunity__success').modal('show');
                        }
                    }
                },
                error: function(){
                    alert('ACK ajax error!')
                }
            });
        });

        $('button#prev-button, button#prev-button-up').on( "click", function() {
            let oid = $("input[name=oid]").val();
            $.ajax({
                type: "GET",
                url: SITE_URL+"/draft-opportunity/"+oid,
                success: function(data){
                    if(data.status==true) {
                        var current = $('.step-progress-bar').find('.current');
                        var prev = current.prev();
                        // Refresh current step
                        if(current && prev && prev.length > 0) {
                            current.removeClass('current'); 
                            prev.removeClass('success');
                            prev.addClass('current'); 
                            
                            // Show prev slide
                            prevSlideFncn();
                        }
                    } else {

                    }
                },
                error: function(){
                    alert('ACK ajax error!')
                }
            });
        });

        function nextSlideFncn() {  
           inTransition = true;
           currentSlide = $('.current-slide');
           nextSlide = currentSlide.next(); 
          
           nextSlide.show(); 
           currentSlide.animate({opacity: 0}, {
             step: function(now, mix) {
               scale = 1 - (1 - now) * 0.2;
               left = (now * 100) + '%'; 
               opacity = 1 - now;
               currentSlide.css({
                 '-webkit-transform': 'scale(' + scale + ')',
                 '-ms-transform': 'scale(' + scale + ')',
                 'transform': 'scale(' + scale + ')'
               }); 
               nextSlide.css({
                 '-webkit-transform': 'translateX(' + left + ')', 
                 '-ms-transform': 'translateX(' + left + ')', 
                 'transform': 'translateX(' + left + ')', 
                 'opacity': opacity});
             },
             duration: 250,
             complete: function() { 
               currentSlide.hide();
               currentSlide.removeClass('current-slide'); 
               nextSlide.addClass('current-slide'); 
               nextSlide.css({'position': 'relative'});
               inTransition = false;
             },
             easing: 'linear' 
           });
        }
        
        function prevSlideFncn() {
           inTransition = true;
           currentSlide = $('.current-slide');
           previousSlide = currentSlide.prev(); 
          
           previousSlide.show(); 
           currentSlide.css({'position': 'absolute'});
           currentSlide.animate({opacity: 0}, {
             step: function(now, mix) {
               scale = 0.8 + (1 - now) * 0.2; 
               left = ((1 - now) * 50) + '%';
               opacity = 1 - now;
               currentSlide.css({
                 '-webkit-transform': 'translateX(' + left + ')',
                 '-ms-transform': 'translateX(' + left + ')',
                 'transform': 'translateX(' + left + ')'
               });
               previousSlide.css({
                 '-webkit-transform': 'scale(' + scale + ')', 
                 '-ms-transform': 'scale(' + scale + ')', 
                 'transform': 'scale(' + scale + ')', 
                 'opacity': opacity
               });
             },
             duration: 250,
             complete: function() { 
               currentSlide.hide();
               currentSlide.removeClass('current-slide');
               previousSlide.addClass('current-slide'); 
               previousSlide.css({'position': 'relative'});
               inTransition = false;
             },
             easing: 'linear'
           });
        }

    });
    </script>
@endsection

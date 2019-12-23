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
              <div class="col-md-9 col-lg-9 main-page__middle-section--outer create-opportunity__section">
                <div class="middle-scroll-section__outer">
                  <div class="step-slider-create-oppor">
                    <div class="center">
                      <div class="for-step-bar__titles" style="display:none">
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
                                <input type="text" class="form-control frminput" id="otitle" placeholder="Email and social media specialist (E-Commerce)" name="otitle" value="{{$opportunity->opportunity}}" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback" id="otitle-error">Please fill out this field.</div>
                              </div>
                              <div class="row">
                                <div class="col-md-2">
                                  <div class="form-group" id="create-oppor-dates">
                                    <div class="input-group date" id="startDate">
                                      <label for="start_dm">Start Date</label>
                                      <input type="text" class="form-control frminput" id="start_dm" name="start_dm" value="{{ date_format(date_create($opportunity->start_date),'m/d') }}" readonly="readonly">
                                      <span class="input-group-addon">
                                      <i class="fas fa-calendar-alt"></i>
                                      </span>
                                    </div>
                                    <div class="create-oppor-dates__selected" id="start_date_frmt">{{ date_format(date_create($opportunity->start_date),"D, M d, Y") }}</div>
                                    <input type="hidden" id="start_date" name="start_date" value="{{ date_format(date_create($opportunity->start_date),'Y-m-d H:i:s') }}" readonly="readonly">
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback" id="start_dm-error">Please fill out this field.</div>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group" id="create-oppor-dates">
                                    <div class="input-group date" id="endDate">
                                      <label for="end_dm">End Date</label>
                                      <input type="text" class="form-control frminput" id="end_dm" name="end_dm" value="{{ date_format(date_create($opportunity->end_date),'m/d') }}" readonly="readonly">
                                      <span class="input-group-addon">
                                      <i class="fas fa-calendar-alt"></i>
                                      </span>
                                    </div>
                                    <div class="create-oppor-dates__selected" id="end_date_frmt">{{ date_format(date_create($opportunity->end_date),"D, M d, Y") }}</div>
                                    <input type="hidden" id="end_date" name="end_date" value="{{ date_format(date_create($opportunity->end_date),'Y-m-d H:i:s') }}" readonly="readonly">
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback" id="end_dm-error">Please fill out this field.</div>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group" id="create-oppor-dates">
                                    <div class="input-group date" id="applyBefore">
                                      <label for="apply_dm">Apply Before</label>
                                      <input type="text" class="form-control frminput" id="apply_dm" name="apply_dm" value="{{ date_format(date_create($opportunity->apply_before),'m/d') }}" readonly="readonly">
                                      <span class="input-group-addon">
                                      <i class="fas fa-calendar-alt"></i>
                                      </span>
                                    </div>
                                    <div class="create-oppor-dates__selected" id="apply_before_frmt">{{ date_format(date_create($opportunity->apply_before),"D, M d, Y") }}</div>
                                    <input type="hidden" id="apply_before" name="apply_before" value="{{ date_format(date_create($opportunity->apply_before),'Y-m-d H:i:s') }}" readonly="readonly">
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback" id="apply_dm-error">Please fill out this field.</div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6 create-oppor-form__coin-counter create-oppor-form__experts-opt">
                                  <div class="form-group">
                                      <label for="oexperts">How many expert(s) do you need for this opportunity?</label>
                                      <div class="number experts">
                                      <input type="text" class="form-control inp-num nonzero frminput" id="oexperts" placeholder="" name="oexperts" value="{{ ($opportunity->expert_qty>0)?$opportunity->expert_qty:1 }}" pattern="^0*[1-9]\d*$" maxlength="5" required>
                                      </div>
                                      <div class="valid-feedback">Valid.</div>
                                      <div class="invalid-feedback" id="oexperts-error">Please fill out this field.</div>
                                  </div>
                                </div>
                                <div class="col-md-6 create-oppor-form__coin-counter create-oppor-form__experts-opt">
                                  <div class="form-group">
                                      <label for="oexperts_hrs">How many hours do you need the expert(s)?</label>
                                      <div class="number experts">
                                      <input type="text" class="form-control inp-num nonzero frminput" id="oexperts_hrs" placeholder="" name="oexperts_hrs" value="{{ ($opportunity->expert_hrs>0)?$opportunity->expert_hrs:1 }}" pattern="^0*[1-9]\d*$" maxlength="5" required>
                                      </div>
                                      <div class="valid-feedback">Valid.</div>
                                      <div class="invalid-feedback" id="oexperts_hrs-error">Please fill out this field.</div>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="odesc">Summary</label>
                                <textarea class="form-control frminput" rows="3" id="odesc" name="odesc" placeholder="Focused on the delivery of relevant and content-rich emails and posts.">{{ $opportunity->opportunity_desc }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback" id="odesc-error">Please fill out this field.</div>
                              </div>
                              <div class="form-group">
                                <label for="incentives">What are the incentives?</label>
                                <textarea class="form-control frminput" rows="4" id="incentives" name="incentives" placeholder="Kloves research is developing a proof-of-concept prototype, and will evaluate end-to-end system performance. Gain industry skills in this project.">{{ $opportunity->incentives }}</textarea>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback" id="incentives-error">Please fill out this field.</div>
                              </div>
                              <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rewards">Rewards</label>
                                    <input type="text" class="form-control frminput" id="rewards" placeholder="$150 Gift Card" name="rewards" value="{{ $opportunity->rewards }}" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback"  id="rewards-error">Please fill out this field.</div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tokens">How many tokens?</label>
                                    <div class="create-oppor-form__coin-counter">
                                    <i class="fas fa-coins gold-coins-color" aria-hidden="true"></i>
                                    <div class="number">
                                        <input type="text" name="tokens" id="tokens" value="{{ ($opportunity->tokens>0)?$opportunity->tokens:1 }}" class="form-control inp-num frminput nonzero" maxlength="5">
                                    </div>
                                    </div>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback" id="tokens-error">Please fill out this field.</div>
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
                                <div class="invalid-feedback" id="skills-error">Please fill out this field.</div>
                              </div>
                              <div class="form-pillbox form-group create-opportunity__pills-dropdown create-opportunity__pills-dropdown--for-focus-area clearfix">
                                <label>Focus Area</label>
                                <select class="multiple-pills-dropdown custom-select" id="focus_area" name="focus_area[]" multiple="multiple">
                                @foreach ($focusArea as $focusAr)
                                    <option value="{{ $focusAr->tid }}" {{ (in_array($focusAr->tid, $selectedFocusAr))?"selected":"" }}>{{ $focusAr->name }}</option>
                                @endforeach
                                </select>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback" id="focus_area-error">Please fill out this field.</div>
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
                              @foreach ($usersApplied as $user)
                              <div class="opportunity-details__candidates-applied">
                                <div class="opportunity-details__candidates-applied--user-details">
                                  <div class="opportunity-details__candidates-pic">
                                    <i class="fas fa-user-circle" aria-hidden="true"></i>
                                    <i class="fas fa-cubes user-pic__cube"></i>
                                  </div>
                                  <div class="opportunity-details__candidates-details">
                                    {{ $user["user_details"]["firstName"] }}
                                  </div>
                                </div>
                                <div class="opportunity-details__candidates-applied--actions-list">
                                  <ul>
                                    <li class="screen__user-approve" data-oid='{{ $user["oid"] }}' data-org_uid='{{ $user["org_uid"] }}'>
                                        <i class="far fa-check-circle {{($user['approve']==1)?'text-success':''}}"></i>
                                        <a href="#" class="{{($user['approve']==1)?'text-success':''}}">Approve</a>
                                    </li>
                                    <li class="screen__user-reject" data-oid='{{ $user["oid"] }}' data-org_uid='{{ $user["org_uid"] }}'>
                                        <i class="far fa-times-circle {{($user['approve']==2)?'text-danger':''}}"></i>
                                        <a href="#" class="{{($user['approve']==2)?'text-danger':''}}">Reject</a>
                                    </li>
                                    <li><i class="far fa-comment-alt"></i><a href="#">Comment</a></li>
                                  </ul>
                                </div>
                              </div>
                              @endforeach
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
          <div class="col-md-3 col-lg-3 main-page__right-section--outer">
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
          window.location.href = "<?=url('/')?>/published-opportunity/<?=$encryptOid?>";
        }

        $( "button#btn-opr-save, button#btn-opr-publish, button#btn-opr-u-save, button#btn-opr-u-publish" ).on( "click", function() {
            var data_array = $("#opportunity-store").serializeArray();
            
            let btnVal = $(this).attr('id');
            var saveUrl = "";
            if(btnVal=="btn-opr-publish" || btnVal=="btn-opr-u-publish") {
                data_array.push({name: 'status', value: 1});
                saveUrl = "/store-opportunity";
            } else {
                data_array.push({name: 'status', value: 0});
                saveUrl = "/store-draft-opportunity";
            }

            $.ajax({
                type: "POST",
                url: SITE_URL + saveUrl,
                data: data_array,
                success: function(data){
                    $('.invalid-feedback').hide();
                    if(data.status==false) {
                        $.each(data.message, function( index, value ) {
                            var error_elem =  $("#"+index).closest(".form-group").find(".invalid-feedback");
                            error_elem.show()
                            error_elem.text(value[0]);
                        });
                    } else if(data.status==true) {
                        if(btnVal=="btn-opr-publish" || btnVal=="btn-opr-u-publish") {
                            window.location.href = "<?=url('/')?>/published-opportunity/<?=$encryptOid?>";
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

        $(".screen__user-approve").on( "click", function() {
            let elem = this;
            let oid = $(elem).data('oid');
            let org_uid = $(elem).data('org_uid');

            if(!$(elem).find('i').hasClass("text-success")) {
                $.ajax({
                  type: "POST",
                  url: SITE_URL+"/approve-opportunity",
                  data: { "oid": oid, "org_uid": org_uid },
                  success: function(data){
                      if(data.status==true) {
                        $(elem).find('i').addClass("text-success");
                        $(elem).find('a').addClass("text-success");

                        $(elem).next('.screen__user-reject').find('i').removeClass("text-danger");
                        $(elem).next('.screen__user-reject').find('a').removeClass("text-danger");
                      }
                  },
                  error: function(){
                      alert('ACK ajax error!')
                  }
                });
            }
        });

        $(".screen__user-reject").on( "click", function() {
            let elem = this;
            let oid = $(elem).data('oid');
            let org_uid = $(elem).data('org_uid');

            if(!$(elem).find('i').hasClass("text-danger")) {
                $.ajax({
                  type: "POST",
                  url: SITE_URL+"/disapprove-opportunity",
                  data: { "oid": oid, "org_uid": org_uid },
                  success: function(data){
                      if(data.status==true) {
                        $(elem).find('i').addClass("text-danger");
                        $(elem).find('a').addClass("text-danger");

                        $(elem).prev('.screen__user-approve').find('i').removeClass("text-success");
                        $(elem).prev('.screen__user-approve').find('a').removeClass("text-success");
                      }
                  },
                  error: function(){
                      alert('ACK ajax error!')
                  }
                });
            }
        });

    });

    
    </script>
@endsection

@extends('layouts.app')
@section('content')
<div class="container">
            <div class="row clearfix">
               <div class="main-contnt-body">
                     <div class="opportunity-detail-published-wrapper">
                  <div class="row">
                    
                     <!--FIRST CARD START-->
                     <div class="col-md-12 col-lg-12 opportunity-detail__left-section--outer opportunity-detail-published-content">
                        
                        <div class="opportunity-detail-published__top-section">
                           <a href="{{ route('list-opportunity') }}">
                           <div class="cmmn-button__black-bg ripple-effect">
                                <i class="fas fa-door-open" aria-hidden="true"></i>
                              <span>View my opportunities for candidates</span>
                           </div>
                           </a>

                           <div class="common-icons__paginations">
                                <a href="{{ (!empty($prevOpportunity))?url('published-opportunity', $prevOpportunity):'' }}" class="common-icons__paginations--for-left-pagination ripple-effect {{(empty($prevOpportunity))?'disabled':''}}"><i class="fas fa-chevron-left"></i></a>
                                <a href="{{ (!empty($nextOpportunity))?url('published-opportunity', $nextOpportunity):'' }}" class="common-icons__paginations--for-right-pagination ripple-effect {{(empty($nextOpportunity))?'disabled':''}}"><i class="fas fa-chevron-right"></i></a>
                           </div>
                        </div>

                        
                        <div class="main-page__cmmn-card opportunity-detail-page__card opportunity-detail-published__card">
                           <div class="opportunity-published__card--top-bottom">
                                 <div class="row clearfix">
                                       <div class="col-md-3">
                                            <!--<i class="fas fa-file-upload"></i>
                                             <span class="common-heading-text--card">Published</span>-->
                                            <div class="common-user-info__header--section publish-opor__creator">
												
                                                @if(!empty($opportunity->creator->profile["image_name"]))
													<div class="publish-page-cmn-card__user-pic" style="background: url('{{ $opportunity->creator->profile['image_url'] }}') ;"></div>
												@else
													<i class="fas fa-user-circle fa-2x" aria-hidden="true"></i>
												@endif
                                                
                                                
                                                <div class="common-user-info__header--section-user-name">{{$opportunity->creator->firstName}}</div>
                                                <div class="common-user-info__header--section-user-desg">{{$opportunity->creator->profile->department}}</div>
                                            </div>
                                       </div>
                                       <div class="col-md-3">
                                          <div class="opportunity-published__card--social-icons">
                                            @if(isset($opportunity->user_actions->like) && ($opportunity->user_actions->like == 1))
                                                <a href="javascript:void(0)" class="likeOppBtn{{$opportunity->id}}" data-action="unlike"  data-oid="{{$opportunity->id}}"><i class="fas fa-thumbs-up"></i></a>
                                            @else
                                                <a href="javascript:void(0)" class="likeOppBtn{{$opportunity->id}}" data-action="like"  data-oid="{{$opportunity->id}}"><i class="far fa-thumbs-up"></i></a>
                                            @endif
            
                                            @if(isset($opportunity->user_actions->favourite) &&($opportunity->user_actions->favourite == 1))
                                                <a href="javascript:void(0)" class="favOppBtn{{$opportunity->id}}" data-action="unfav"  data-oid="{{$opportunity->id}}"><i class="fas fa-heart"></i></a>
                                            @else
                                                <a href="javascript:void(0)" class="favOppBtn{{$opportunity->id}}" data-action="fav"  data-oid="{{$opportunity->id}}"> <i class="far fa-heart"></i></a>
                                            @endif

                                             <i class="far fa-comment" aria-hidden="true"></i>

                                             <a href="#mainPage__sharetoExpert" class="shareBtn{{$opportunity->id}}" data-remote="{{ url('share-feed', Crypt::encrypt($opportunity->id)) }}" data-toggle="modal" data-target="#mainPage__sharetoExpert" data-share_type="OPP"><i class="far fa-share-square"></i></a> 
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="opportunity-published-card__common-button oppor__btn-block">
                                            @if(empty($opportunity->job_start_date))
                                             <a href="JavaScript:Void(0);" class="oppor__draft" data-oid='{{ $opportunity->id }}'><i class="fas fa-arrow-left"></i><span>Back to draft</span></a>
                                             
                                             <a href="JavaScript:Void(0);" class="oppor__start-job {{(!empty($opportunity->expert_qty) && (count($usersApproved)==$opportunity->expert_qty) || (count($usersApproved)>0 && Carbon\Carbon::now() >= Carbon\Carbon::parse($opportunity->start_date)))?'start-active':'disabled'}}" data-oid='{{ $opportunity->id }}'><span>Start Job</span></a>
                                             
                                             <a href="JavaScript:Void(0);" class="oppor__cancel" data-oid='{{ $opportunity->id }}'><span class="opportunity-published-card__common-button--cancel">Withdraw</span></a>
                                            @elseif(empty($opportunity->job_complete_date))
                                             <a href="JavaScript:Void(0);" class="oppor__complete-job" data-oid='{{ $opportunity->id }}'><span>Complete</span></a>
                                            @endif
                                          </div>
                                       </div>
                                    </div>
                           </div>


                           <div class="common-black-strip-for-status-message"> <i class="fas fa-file-upload"></i> Published
                           </div>
                           <div class="opportunity-published-page__card--content">
                                 <div class="row clearfix">
                                    <div class="col-md-6">
                                       <div class="common-opportunity-heading__inner-page">
                                            {{$opportunity->opportunity}}
                                       </div>

                                       <div class="oppor-published-card__common-list-details">
                                             <ul>
                                                <li><span class="for-fnt-weight">Start: {{ date_format(date_create($opportunity->start_date),"D, M d, Y") }}</span></li>
                                                <li><span class="for-fnt-weight">End: {{ date_format(date_create($opportunity->end_date),"D, M d, Y") }}</span></li>
                                                <li ><span class="for-fnt-weight">Apply by: {{ date_format(date_create($opportunity->end_date),"D, M d, Y") }}</span></li>
                                                <br/>
                                                <li style="display:none;">Allocated <span class="for-fnt-weight">15hrs</span></li>
                                                <li><span class="for-fnt-weight">{{$opportunity->expert_hrs}} hrs/wk</span></li>
                                                <li><span class="for-fnt-weight">{{count($usersApproved)}}</span> of <span class="for-fnt-weight">{{$opportunity->expert_qty}}</span> candidate(s)</li>
                                                <!-- <li><span class="red-colr-txt">
                                                <span class="oppor-match__left">{{$opportunity->expert_qty - count($usersApproved)}}</span> spots left, last day to connect is {{ date_format(date_create($opportunity->apply_before),"D, M d, Y") }}
                                                </span></li> -->
                                                <!-- <li><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="for-fnt-weight">{{$opportunity->tokens}}</span></li> -->
                                             </ul>
                                       </div>

                                       <div class="oppor-create-card__content-summary">
                                             <div class="oppor-create-card__content--cmmn-heading">Summary</div>
                                             <p>{{$opportunity->opportunity_desc}}</p>
                                       

                                             <div class="oppor-create-card__content--cmmn-heading">What are the incentives?</div>
                                             <p>{{$opportunity->incentives}}</p>

                                             <div class="oppor-create-card__content--cmmn-heading">Reward</div>
                                             <p>{{$opportunity->rewards}}</p>
                                             <p><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="for-fnt-weight">{{$opportunity->tokens}}</span></p>
                                   
                                     </div>

                                    </div>
                                 <!--------------RIGHT SECTION START--------------->
                                    <div class="col-md-6">
                                          <div class="common-opportunity-heading__inner-page common-opportunity-heading-small__inner-page">
                                                Candidates – <span class="oppor-match__approved">{{count($usersApproved)}}</span> of {{$opportunity->expert_qty}} matched
                                          </div>
                                          <div class="match__user-list">
                                          @foreach($usersApproved as $user)
											  @if(!empty($user["profile_image"]["profile_image"]))
												<div class="common-user-pic-and__name-for-published" id="match__user-{{$user['org_uid']}}" style="background: url('{{ $user['profile_image']['profile_image'] }}') ;">
													<span>{{ $user["user_details"]["firstName"] }}</span>
												</div>
											@else
												<div class="common-user-pic-and__name-for-published" id="match__user-{{$user['org_uid']}}">
													 <i class="fas fa-user-circle fa-3x" aria-hidden="true"></i>
													 <span>{{ $user["user_details"]["firstName"] }}</span>
												</div>	 
											@endif
                                          
                                          @endforeach
                                          </div>

                                          <div class="oppor-create-card__content--cmmn-heading">Skills</div>
                                          <div class="cmmn__pills common_pills__black-border">
                                            <ul>
                                            @foreach ($skills as $skill)
                                                <?=(in_array($skill->tid, $selectedSkills))?"<li><a href='#'>$skill->name</a></li>":""?>
                                            @endforeach
                                             </ul>
                                          </div>

                                          <div class="oppor-create-card__content--cmmn-heading">Focus areas</div>
                                          <div class="cmmn__pills common_pills__black-border">
                                             <ul>
                                             @foreach ($focusArea as $focusAr)
                                                <?=(in_array($focusAr->tid, $selectedFocusAr))?"<li><a href='#'>$focusAr->name</a></li>":""?>
                                             @endforeach
                                             </ul>
                                          </div>
                                    </div><!-------COL-MD-6-CLOSED-->
                                 </div>
                           </div>



                           <div class="opportunity-published__card--top-bottom">
                           <div class="opportunity-published-card__common-button oppor__btn-block">
                            @if(empty($opportunity->job_start_date))
                                <a href="JavaScript:Void(0);" class="oppor__draft" data-oid='{{ $opportunity->id }}'><i class="fas fa-arrow-left"></i><span>Back to draft</span></a>

                                <a href="JavaScript:Void(0);" class="oppor__start-job {{(!empty($opportunity->expert_qty) && (count($usersApproved)==$opportunity->expert_qty) || (count($usersApproved)>0 && Carbon\Carbon::now() >= Carbon\Carbon::parse($opportunity->start_date)))?'start-active':'disabled'}}" data-oid='{{ $opportunity->id }}'><span>Start Job</span></a>

                                <a href="JavaScript:Void(0);" class="oppor__cancel" data-oid='{{ $opportunity->id }}'><span class="opportunity-published-card__common-button--cancel">Withdraw</span></a>
                            @elseif(empty($opportunity->job_complete_date))
                                <a href="JavaScript:Void(0);" class="oppor__complete-job" data-oid='{{ $opportunity->id }}'><span>Complete</span></a>
                            @endif
                                 
                            </div>
                           </div>
                
                           <!-- <div class="opportunity-detail-page__card--top-bottom">
                                 <div class="row clearfix">                                        
                                       <div class="col-md-12">
                                          <div class="opportunity-detail-page__card--apply-btn">
                                             <a href="#">Apply</a>
                                          </div>
                                       </div>
                                    </div>
                           </div> -->

                        </div>
						<!------->

               </div>
               
               <!------SECOND CARD START----------->
               <div class="col-md-12 col-lg-12 opportunity-detail__left-section--outer opportunity-detail-published-content">
                  <div class="main-page__cmmn-card opportunity-detail-page__card opportunity-detail-published__card">
                     <div class="opportunity-published__card--top-bottom">
                        <div class="common-heading-text--card common-semibold-heading">
                           <span>{{count($usersApplied)}} Candidates match your opportunity, <span class="oppor-match__approved">{{count($usersApproved)}}</span> of {{$opportunity->expert_qty}} have been selected.</span>                               
                        </div>

                        <div class="common-heading-text--card__invite-action">
                            <a href="#mainPage__invitetoApply" class="inviteBtn{{$opportunity->id}}" data-remote="{{ url('opportunity-invite', Crypt::encrypt($opportunity->id)) }}" data-toggle="modal" data-target="#mainPage__invitetoApply">[+] Invite</a>
                        </div>
                     </div>
                     <div class="opportunity-published-page__card--content">
                          

                        <div class="common-user-detail__cards-outer">
                            @if(count($usersApplied)>0)
                            @php $userItem = 0; @endphp
                                @foreach ($usersApplied as $key=>$user)
                                @if($userItem==0)
                                <ul class="card-wrapper__with-flex">
                                @endif
                                 <li class="flex-item">
                                    <div class="common__user-detail-card">
										
											<div class="common__user-details-card--comments user_comments" id="user_comments" data-user_id="{{$user['org_uid']}}" data-opp_id="{{$opportunity->id}}" data-toggle="modal">
												 <i class="far fa-comment-alt"></i>
											 @if($user['comment_count'] > 0)	 
												 <span class="common__user-details-card--comments-counter" id="cnt_comment{{$user['org_uid']}}">{{$user['comment_count']}}</span>
											@endif		 
											</div>
										
                                            @if(!empty($user["profile_image"]["profile_image"]))
                                                <div class="common__user-detail-card--user-picture" style="background:url('{{ $user['profile_image']['profile_image'] }}');"></div>
                                            @else
                                                <div class="common__user-detail-card--user-picture"><i class="fas fa-user-circle fa-7x" aria-hidden="true"></i></div>
                                            @endif
                                        
                                        <div class="common__user-detail-card--user-name">{{ $user["user_details"]["firstName"] }}</div>
                                        <div class="common__user-detail-card--user-status">
                                            <i class="fas fa-clock"></i>
                                            <span>
                                            @if($user["approve"]==1)
                                                Match
                                            @elseif($user["approve"]==2)
                                                Mismatch
                                            @else
                                                Awaiting decision
                                            @endif
                                            </span>
                                        </div>
                                        <div class="common__user-detail-card--action-buttons">
                                            @if($user["approve"]==0)
                                                <a href="JavaScript:Void(0);" class="screen__user-reject" data-oid='{{ $user["oid"] }}' data-org_uid='{{ $user["org_uid"] }}'>
                                                    <i class="fas fa-times-circle for-element-with--fire-brick-color mismatch-action-btn"></i>
                                                </a>
                                                
                                                <a href="JavaScript:Void(0);" class="screen__user-approve" data-oid='{{ $user["oid"] }}' data-org_uid='{{ $user["org_uid"] }}'>
                                                    <i class="fas fa-check-circle for-element-with--green--light-color approve-action-btn"></i>
                                                </a>
                                            @else
                                                <a href="JavaScript:Void(0);" class="screen__user-dismiss" data-oid='{{ $user["oid"] }}' data-org_uid='{{ $user["org_uid"] }}'><i class="fas fa-ban"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                 </li>
                                 @php $userItem++; @endphp
                                @if($userItem==7 || $key==count($usersApplied)-1)
                                @php $userItem=0; @endphp
                                 </ul>
                                 @endif
                                @endforeach
                            @else
                                No candidate has applied for this opportunity!
                            @endif
                            
                           </div>
                     </div><!-------opportunity-published-page__card--content-->
                    </div>
               </div>


<!------THIRD CARD START----------->
               <div class="col-md-12 col-lg-12 opportunity-detail__left-section--outer opportunity-detail-published-content">
                  <div class="main-page__cmmn-card opportunity-detail-page__card opportunity-detail-published__card">
                     <div class="opportunity-published__card--top-bottom">
                        <div class="common-heading-text--card common-semibold-heading">
                           <span>Recommended candidates for you based on skills and focus areas</span>                               
                        </div>
                           <div class="common-heading-text--card__invite-action">
                             <a href="#mainPage__invitetoApply" class="inviteBtn" data-remote="{{ url('opportunity-invite', Crypt::encrypt($opportunity->id)) }}" data-toggle="modal" data-target="#mainPage__invitetoApply">[+] Invite</a>
                           </div>
                        </div>

                        <div class="opportunity-published-page__card--content">
                        <div class="common-user-detail__cards-outer">
                        
                        @php $rowItem = 0; @endphp
                        @foreach($recommendations as $key => $rUser)
                            @if($rowItem==0)
                            <ul class="card-wrapper__with-flex">
                            @endif
                                <li class="flex-item" data-uid="{{ $rUser["user_details"]["id"] }}">
                                    <div class="common__user-detail-card">
										
											<div class="common__user-details-card--comments user_comments" id="user_comments" data-user_id="{{$rUser['user_id']}}" data-opp_id="{{$opportunity->id}}" data-toggle="modal">
												 <i class="far fa-comment-alt"></i>
												 @if($rUser['comment_count'] > 0)
													<span class="common__user-details-card--comments-counter"  id="cnt_comment{{$rUser['user_id']}}">{{$rUser['comment_count']}}</span>
												 @endif	
											</div>
									    	
                                            @if(!empty($rUser["profile_image"]["profile_image"]))
                                                <div class="common__user-detail-card--user-picture" style="background:url('{{ $rUser['profile_image']['profile_image'] }}')"></div>
                                            @else
                                                <div class="common__user-detail-card--user-picture"><i class="fas fa-user-circle fa-7x" aria-hidden="true"></i> </div>
                                            @endif
                                       
                                        <div class="common__user-detail-card--user-name">{{ $rUser["user_details"]["firstName"] }}</div>
                                        <div class="common__user-detail-card--invite-button">
                                             @if (in_array($rUser["user_details"]["id"], $alreadyInvitedUsers))
                                             <a href="javascript:void(0)" class="invitedUserBtn{{$rUser['user_details']['id']}}" data-action="SINGLE-INVITE" data-opp_id="{{$opportunity->id}}" data-user_id="{{ $rUser['user_details']['id'] }}">Invited</a>
                                            @else 
                                                <a href="javascript:void(0)" class="inviteUserBtn{{$rUser['user_details']['id']}}" data-action="SINGLE-INVITE" data-opp_id="{{$opportunity->id}}" data-user_id="{{ $rUser['user_details']['id'] }}">[+] Invite</a>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @php $rowItem++; @endphp
                            @if($rowItem==7 || $key==count($recommendations)-1)
                            @php $rowItem=0; @endphp
                            </ul>
                            @endif
                        @endforeach
                        </div>
                        </div>
                     </div>
                  </div>         
                  </div>
                  </div><!-----opportunity-details__wrapper-END-->
               </div>
            </div>
         </div>

         <div class="modal fade main-page__cmmn_modal" id="opportunity__error">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
		  <div id="thanks_up" class="hidden"></div>
				<!-- Modal body -->
				<div class="modal-body text-center"><b id="opportunityErrMsg"></b></div>
		  </div>
		</div>
	  </div>
<!--------COMMENTS-MODAL-START------------------->
      <!-- The Modal -->
  <div class="modal fade" id="user-details-comments__modal">
    <div class="modal-dialog">
    <button type="button" class="close user-details-modal__close-button" data-dismiss="modal">&times;</button>
      <div class="modal-content">
        <!-- Modal Header -->
        <!-- Modal body -->
        <div class="modal-body">				
				<div class="search-drawer-input for-comments-popup__on-user-card">
					<input type="text" id="comment" name="comment" class="form-control frminput" placeholder="Type your message here…">
					<input type="hidden" id="user_to_id" value="" class="form-control">
					<input type="hidden" id="org_id" value="" class="form-control">
					<div class="valid-feedback">Valid.</div>
					<div class="invalid-feedback" id="comment-error">Please fill out this field.</div>
				</div> 
				<div class="search-drawer-content-btn">
					<button type="button" id="post_comment__btn" class="search-drawer-btn">Post</button>
				</div>
			<!------MODAL-COMMENTS-AREA-START------->
			<div id="show_org_comment"></div>
		 <!------MODAL-COMMENTS-AREA-END------->
        </div>
        
        <!-- Modal footer -->
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div> -->
        
      </div>
    </div>
  </div>
 <!--------COMMENTS-MODA-END------------------->
    <script>
    $(document).ready(function() {
        var oppr_status = "<?=$opportunity->status?>";
        if(oppr_status=="<?=config('kloves.RECORD_STATUS_INACTIVE')?>") {
          window.location.href = "<?=url('/')?>/create-opportunity/<?=$encryptOid?>";
        }


        var approvedUsers = "<?=count($usersApproved)?>";
        var requiredUsers = "<?=$opportunity->expert_qty?>";
        $(document).on('click', ".screen__user-approve", function() {
            let elem = this;
            let oid = $(elem).data('oid');
            let org_uid = $(elem).data('org_uid');
            if(approvedUsers<requiredUsers) {
                $.ajax({
                  type: "POST",
                  url: SITE_URL+"/approve-opportunity",
                  data: { "oid": oid, "org_uid": org_uid },
                  success: function(data){
                      if(data.status==true) {
                        approvedUsers++;
                        $(".oppor-match__approved").html(approvedUsers);
                        $(".oppor-match__left").html(requiredUsers-approvedUsers);
                        $(elem).parent().prev().find("span").html("Match");
                        
                        let parentHtml = "<a href='JavaScript:Void(0);' class='screen__user-dismiss' data-oid='"+oid+"' data-org_uid='"+org_uid+"'><i class='fas fa-ban'></i></a>";
                        $(elem).parent().html(parentHtml);

                        var imgData = '<i class="fas fa-user-circle fa-3x" aria-hidden="true"></i>';
                        if(data.userData.profile_image !=null && data.userData.profile_image.profile_image!="") {
                            imgData = '<img src="'+data.userData.profile_image.profile_image+'">';
                        }
                        var matchedHtml = '<div class="common-user-pic-and__name" id="match__user-'+org_uid+'">\
                                '+imgData+'\
                                <span>'+data.userData.firstName+'</span>\
                            </div>';
                        $(".match__user-list").append(matchedHtml);

                        var currentDateTime = new Date($.now());
                        var opprDateTime = new Date("<?=$opportunity->start_date?>");
                        if((requiredUsers>0 && requiredUsers==approvedUsers) || (approvedUsers>0 && currentDateTime>=opprDateTime)) {
                            $(".oppor__start-job").removeClass("disabled");
                            $(".oppor__start-job").addClass("start-active");
                        } else {
                            $(".oppor__start-job").addClass("disabled");
                            $(".oppor__start-job").removeClass("start-active");
                        }

                      }
                  },
                  error: function(){
                      alert('ACK ajax error!')
                  }
                });
            } else {
                $("#opportunityErrMsg").html("Sorry, No spots left for this opportunity!");
                $('#opportunity__error').modal('show');
            }
        });

        $(document).on('click', ".screen__user-reject", function() {
            let elem = this;
            let oid = $(elem).data('oid');
            let org_uid = $(elem).data('org_uid');

                $.ajax({
                  type: "POST",
                  url: SITE_URL+"/disapprove-opportunity",
                  data: { "oid": oid, "org_uid": org_uid },
                  success: function(data){
                      if(data.status==true) {
                          $(elem).parent().prev().find("span").html("Mismatch");

                          let parentHtml = "<a href='JavaScript:Void(0);' class='screen__user-dismiss' data-oid='"+oid+"' data-org_uid='"+org_uid+"'><i class='fas fa-ban'></i></a>";
                          $(elem).parent().html(parentHtml);

                          $("#match__user-"+org_uid).remove();

                          var currentDateTime = new Date($.now());
                          var opprDateTime = new Date("<?=$opportunity->start_date?>");
                          if((requiredUsers>0 && requiredUsers==approvedUsers) || (approvedUsers>0 && currentDateTime>=opprDateTime)) {
                            $(".oppor__start-job").removeClass("disabled");
                            $(".oppor__start-job").addClass("start-active");
                          } else {
                            $(".oppor__start-job").addClass("disabled");
                            $(".oppor__start-job").removeClass("start-active");
                          }
                        
                      }
                  },
                  error: function(){
                      alert('ACK ajax error!')
                  }
                });

        });

        $(document).on('click', ".screen__user-dismiss", function() {
            let elem = this;
            let oid = $(elem).data('oid');
            let org_uid = $(elem).data('org_uid');
            let prevStatus = $.trim($(elem).parent().prev().find("span").html());

                $.ajax({
                  type: "POST",
                  url: SITE_URL+"/dismiss-opportunity",
                  data: { "oid": oid, "org_uid": org_uid },
                  success: function(data){
                      if(data.status==true) {
                          $(elem).parent().prev().find("span").html("Awaiting decision");

                          if(prevStatus=="Match") {
                            approvedUsers--;
                            $(".oppor-match__approved").html(approvedUsers);
                            $(".oppor-match__left").html(requiredUsers-approvedUsers);
                          }

                          let parentHtml = "<a href='JavaScript:Void(0);' class='screen__user-reject' data-oid='"+oid+"' data-org_uid='"+org_uid+"'>\
                                <i class='fas fa-times-circle for-element-with--fire-brick-color mismatch-action-btn'></i>\
                            </a>\
                            <a href='JavaScript:Void(0);' class='screen__user-approve' data-oid='"+oid+"' data-org_uid='"+org_uid+"'>\
                                <i class='fas fa-check-circle for-element-with--green-color approve-action-btn'></i>\
                            </a>";
                          $(elem).parent().html(parentHtml);

                          $("#match__user-"+org_uid).remove();

                            var currentDateTime = new Date($.now());
                            var opprDateTime = new Date("<?=$opportunity->start_date?>");
                            if((requiredUsers>0 && requiredUsers==approvedUsers) || (approvedUsers>0 && currentDateTime>=opprDateTime)) {
                                $(".oppor__start-job").removeClass("disabled");
                                $(".oppor__start-job").addClass("start-active");
                            } else {
                                $(".oppor__start-job").addClass("disabled");
                                $(".oppor__start-job").removeClass("start-active");
                            }

                      }
                  },
                  error: function(){
                      alert('ACK ajax error!')
                  }
                });
        });

        $(document).on("click", ".oppor__draft", function() {
            let elem = this;
            let oid = $(elem).data('oid');
            $.ajax({
                type: "GET",
                url: SITE_URL+"/draft-opportunity/"+oid,
                success: function(data){
                    if(data.status==true) {
                        window.location.href = "<?=url('/')?>/create-opportunity/<?=$encryptOid?>";
                    } else {

                    }
                },
                error: function(){
                    alert('ACK ajax error!')
                }
            });
        });

        $(document).on("click", ".oppor__cancel", function() {
            let elem = this;
            let oid = $(elem).data('oid');
            $.ajax({
                type: "GET",
                url: SITE_URL+"/cancel-opportunity/"+oid,
                success: function(data){
                    if(data.status==true) {
                        window.location.href = "<?=url('/')?>";
                    } else {

                    }
                },
                error: function(){
                    alert('ACK ajax error!')
                }
            });
        });

        $(document).on("click", ".oppor__start-job", function() {
            let elem = this;
            let oid = $(elem).data('oid');
            $.ajax({
                type: "GET",
                url: SITE_URL+"/start-opportunity/"+oid,
                success: function(data){
                    if(data.status==true) {
                        $(".oppor__btn-block").html('<a href="JavaScript:Void(0);" class="oppor__complete-job" data-oid="'+oid+'"><span>Complete</span></a>');
                    }
                }
            });
        });

        $(document).on("click", ".oppor__complete-job", function() {
            let elem = this;
            let oid = $(elem).data('oid');
            $.ajax({
                type: "GET",
                url: SITE_URL+"/complete-opportunity/"+oid,
                success: function(data){
                    if(data.status==true) {
                        $(".oppor__btn-block").html('');
                    }
                }
            });
        });

    });
    
    
     $(document).on("click",'.user_comments', function(){
		//$('.commentbox').jmspinner('small');
		let elem = this;
		let user_id = $(elem).data('user_id');
		let opp_id = $(elem).data('opp_id');
		$.ajax({
			type: "POST",
			url: SITE_URL+"/get_user_comment",
			dataType: 'json',
			data: { "oid": opp_id, "user_id": user_id },
			success: function() {},
			complete: function(data) {
				if(data.responseJSON.status == true) {
					$('#show_org_comment').html(data.responseJSON.comments);
					$('#user_to_id').val(user_id);
					$('#org_id').val(opp_id);
					$('#user-details-comments__modal').modal();
				}
				//$('.commentbox').jmspinner(false);
			}
		});
 });  
    
  $(document).on("click",'#post_comment__btn', function(){
		let elem = this;
		let user_id = $('#user_to_id').val();
		let opp_id = $('#org_id').val();
		var comment = $('#comment').val();
		if(comment != '') {
			$.ajax({
				type: "POST",
				url: SITE_URL+"/post_user_comment",
				dataType: 'json',
				data: { oid: opp_id, user_id: user_id, comment:comment },
				success: function() {},
				complete: function(data) {
					if(data.responseJSON.status == true) {
						$('#show_org_comment').html(data.responseJSON.comments);
						$('#user_to_id').val(user_id);
						$('#org_id').val(opp_id);
						$('#comment').val('');
						$('#cnt_comment'+user_id).text(data.responseJSON.cnt_comment);
					}
					//$('.commentbox').jmspinner(false);
				}
			});
		} else {
			$('#comment-error').html("This field is required.");
			$('#comment-error').show();
		}	
 }); 


    
/** share fxn :start */
function initVueComponent(){
      vm = new Vue({
            el: '#vueComponent',
            data: {
			search : '',
			selectedList : [],
			postIDs : [],
                  items: {!! $shareUserJsonList !!},
            },
            computed: {
                  filteredList() {
                        return this.items.filter(itemVal => {
                        return itemVal.firstName.toLowerCase().includes(this.search.toLowerCase())
                        })
                  }
		},
            methods: {
                 selectRecord( item ){
				var indexOfSelectedItem = this.items.indexOf(item);
				if (indexOfSelectedItem > -1) {
					this.items.splice(indexOfSelectedItem, 1);
					this.selectedList.push( item );
					this.postIDs.push( item.id );
					$("#checkedUsers").val(this.postIDs.toString());
					//$("#checkedUsers").val(($("#checkedUsers").val() + ', ' + item.id).replace(/^, /, ''));
				}
				this.search = '';
		     },
		     removeRecord( item ){ 
				var indexOfSelectedItem = this.selectedList.indexOf(item); 
				if (indexOfSelectedItem > -1) {  //console.log('sss'+indexOfSelectedItem)
					this.items.push( item );

					this.selectedList.splice(indexOfSelectedItem, 1);
					this.postIDs.splice(indexOfSelectedItem, 1);
					$("#checkedUsers").val(this.postIDs.toString());
				}
				this.search = '';
		     },
		     sendInAjax(){

		     }
            }
	});
}
/** share fxn :end */
/** invite opportunity Fxn : STARTS **/
function initInviteVueComponent(){
		// $shareUserList['all']
		vm = new Vue({
			el: '#vueComponent',
			data: {
				search : '',
				selectedList : [],
				postIDs : [],
				items: {!! $inviteUserJSONList !!},
			},
		/*created: function () {
			// `this` points to the vm instance
			console.log('a is: ' + this.a)
			},*/
			computed: {
				filteredList() {
					return this.items.filter(itemVal => {
					return itemVal.firstName.toLowerCase().includes(this.search.toLowerCase())
					})
				}
			},
			methods: {
			selectRecord( item ){
					var indexOfSelectedItem = this.items.indexOf(item);
					if (indexOfSelectedItem > -1) {
						this.items.splice(indexOfSelectedItem, 1);
						this.selectedList.push( item );
						this.postIDs.push( item.id );
						$("#checkedUsers").val(this.postIDs.toString());
						//$("#checkedUsers").val(($("#checkedUsers").val() + ', ' + item.id).replace(/^, /, ''));
					}
					this.search = '';
			},
			removeRecord( item ){ 
					var indexOfSelectedItem = this.selectedList.indexOf(item); 
					if (indexOfSelectedItem > -1) {  //console.log('sss'+indexOfSelectedItem)
						this.items.push( item );

						this.selectedList.splice(indexOfSelectedItem, 1);
						this.postIDs.splice(indexOfSelectedItem, 1);
						$("#checkedUsers").val(this.postIDs.toString());
					}
					this.search = '';
			},
			sendInAjax(){

			}
			}
		});
		
	}
/** invite opportunity Fxn : ENDS **/
</script>

@endsection

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
                           <a href="#">
                           <div class="cmmn-button__black-bg ripple-effect">
                              <i class="fas fa-briefcase" aria-hidden="true"></i>
                              <span>View my opportunities for candidates</span>
                           </div>
                           </a>

                           <div class="common-icons__paginations">
                                <a href="#" class="common-icons__paginations--for-left-pagination ripple-effect"><i class="fas fa-chevron-left"></i></a>
                                <a href="#" class="common-icons__paginations--for-right-pagination ripple-effect"><i class="fas fa-chevron-right"></i></a>
                           </div>
                        </div>

                        
                        <div class="main-page__cmmn-card opportunity-detail-page__card opportunity-detail-published__card">
                           <div class="opportunity-published__card--top-bottom">
                                 <div class="row clearfix">
                                       <div class="col-md-6">
                                             <i class="fas fa-file-upload"></i>
                                             <span class="common-heading-text--card">Published</span>
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
                                       <div class="col-md-3">
                                          <div class="opportunity-published-card__common-button">
                                             <a href="JavaScript:Void(0);" class="oppor__draft" data-oid='{{ $opportunity->id }}'><i class="fas fa-arrow-left"></i><span>Back to draft</span></a>
                                             <a href="JavaScript:Void(0);" class="oppor__cancel" data-oid='{{ $opportunity->id }}'><span class="opportunity-published-card__common-button--cancel">Cancel</span></a>
                                          </div>
                                       </div>
                                    </div>
                           </div>



                           <div class="opportunity-published-page__card--content">
                                 <div class="row clearfix">
                                    <div class="col-md-6">
                                       <div class="common-opportunity-heading__inner-page">
                                            {{$opportunity->opportunity}}
                                       </div>

                                       <div class="oppor-published-card__common-list-details">
                                             <ul>
                                                <li>Est start <span class="for-fnt-weight">{{ date_format(date_create($opportunity->start_date),"D, M d, Y") }}</span></li>
                                                <li>Est end <span class="for-fnt-weight">{{ date_format(date_create($opportunity->end_date),"D, M d, Y") }}</span></li>
                                                <li style="display:none;">Allocated <span class="for-fnt-weight">15hrs</span></li>
                                                <li><span class="red-colr-txt">
                                                <span class="oppor-match__left">{{$opportunity->expert_qty - count($usersApproved)}}</span> spots left, last day to connect is {{ date_format(date_create($opportunity->apply_before),"D, M d, Y") }}
                                                </span></li>
                                                <li><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="for-fnt-weight">{{$opportunity->tokens}}</span></li>
                                             </ul>
                                       </div>

                                       <div class="oppor-create-card__content-summary">
                                             <div class="oppor-create-card__content--cmmn-heading">Summary</div>
                                             <p>{{$opportunity->opportunity_desc}}</p>
                                       

                                             <div class="oppor-create-card__content--cmmn-heading">What are the incentives?</div>
                                             <p>{{$opportunity->incentives}}</p>

                                             <div class="oppor-create-card__content--cmmn-heading">Reward</div>
                                             <p>{{$opportunity->rewards}}</p>
                                   
                                     </div>

                                    </div>
                                 <!--------------RIGHT SECTION START--------------->
                                    <div class="col-md-6">
                                          <div class="common-opportunity-heading__inner-page common-opportunity-heading-small__inner-page">
                                                Candidates – <span class="oppor-match__approved">{{count($usersApproved)}}</span> of {{$opportunity->expert_qty}} matched
                                          </div>
                                          <div class="match__user-list">
                                          @foreach($usersApproved as $user)
                                          <div class="common-user-pic-and__name" id="match__user-{{$user['org_uid']}}">
                                            @if(!empty($user["profile_image"]["profile_image"]))
                                                <img src="{{ $user['profile_image']['profile_image'] }}">
                                            @else
                                                <i class="fas fa-user-circle fa-3x" aria-hidden="true"></i>
                                            @endif
                                                
                                                <span>{{ $user["user_details"]["firstName"] }}</span>
                                          </div>
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
                           <div class="opportunity-published-card__common-button">
                                 <a href="JavaScript:Void(0);" class="oppor__draft" data-oid='{{ $opportunity->id }}'><i class="fas fa-arrow-left"></i><span>Back to draft</span></a>
                                 <a href="JavaScript:Void(0);" class="oppor__cancel" data-oid='{{ $opportunity->id }}'><span class="opportunity-published-card__common-button--cancel">Cancel</span></a>
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
                           <a href="#">[+] Invite</a>
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
                                        <div class="common__user-detail-card--user-picture">
                                            @if(!empty($user["profile_image"]["profile_image"]))
                                                <img src="{{ $user['profile_image']['profile_image'] }}">
                                            @else
                                                <i class="fas fa-user-circle fa-7x" aria-hidden="true"></i>
                                            @endif
                                        </div>
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
                                                    <i class="fas fa-check-circle for-element-with--green-color approve-action-btn"></i>
                                                </a>
                                            @else
                                                <a href="JavaScript:Void(0);" class="screen__user-dismiss" data-oid='{{ $user["oid"] }}' data-org_uid='{{ $user["org_uid"] }}'><i class="fas fa-ban"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                 </li>
                                 @php $userItem++; @endphp
                                @if($userItem==7 || $key==count($recommendations)-1)
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
                                 <a href="#">[+] Invite</a>
                           </div>
                        </div>

                        <div class="opportunity-published-page__card--content">
                        <div class="common-user-detail__cards-outer">
                        
                        @php $rowItem = 0; @endphp
                        @foreach($recommendations as $key => $rUser)
                            @if($rowItem==0)
                            <ul class="card-wrapper__with-flex">
                            @endif
                                <li class="flex-item">
                                    <div class="common__user-detail-card">
                                        <div class="common__user-detail-card--user-picture">
                                            @if(!empty($rUser["profile_image"]["profile_image"]))
                                                <img src="{{ $rUser['profile_image']['profile_image'] }}">
                                            @else
                                                <i class="fas fa-user-circle fa-7x" aria-hidden="true"></i>
                                            @endif
                                        </div>
                                        <div class="common__user-detail-card--user-name">{{ $rUser["user_details"]["firstName"] }}</div>
                                        <div class="common__user-detail-card--invite-button">
                                            <a href="#">[+] Invite</a>                                                
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

</script>

@endsection
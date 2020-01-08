@if(count($opportunities)>0)
@foreach($opportunities as $rowKey => $rowVal)
    <div class="col-md-3">
        <div class="main-page-cmmn-feed-card main-page__cmmn-card cstm-for-search-drawer main-nav__search-item">

            <div class="favorites-cmmn__cards--dots-menu">
                <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
            </div>
            
            <div class="search-drawer-card-cmmn__heading yellow-sea-color-bg">
                Apply by {{ date_format(date_create($rowVal->apply_before),"M d, Y") }}
            </div>

            <div class="main-page-cmmn-feed__content-area search-drawer_card--cntnt">
                <div class="main-page-cmmn-feed-card__heading">
                    <a href="{{ url('view-opportunity', Crypt::encrypt($rowVal->id)) }}">{{ (strlen($rowVal->opportunity)<=25)?$rowVal->opportunity:char_trim($rowVal->opportunity,25) }}</a>
                </div>
                
                <div class="main-page-cmmn-feed-card__desc">
                    {{ (strlen($rowVal->opportunity_desc)<=50)?$rowVal->opportunity_desc:char_trim($rowVal->opportunity_desc,50) }}
                </div>

                @if(Auth::user()->id != $rowVal->org_uid && empty($rowVal->job_start_date) && empty($rowVal->job_complete_date)) 
                    @if(($rowVal->apply == config('kloves.FLAG_SET'))  && ($rowVal->approve == config('kloves.OPP_APPLY_NEW') || $rowVal->approve == config('kloves.OPP_APPLY_APPROVED')) )
                        <a id="withdrawCardBtn{{$rowVal->id}}" class="main-page-cmmn-feed-card__action-search-btn" data-oid="{{$rowVal->id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($rowVal->id)) }}">{{ __('Withdraw') }}</a>
                    @else
                        <a id="applyCardBtn{{$rowVal->id}}" class="main-page-cmmn-feed-card__action-search-btn"  data-oid="{{$rowVal->id}}" href="javascript:void(0)" data-href="{{ url('opportunity/apply', Crypt::encrypt($rowVal->id)) }}" >
                        <span>Interested ?</span>
                    </a>
                    @endif 
                @else
					<a href="javascript:void(0)" class="main-page-cmmn-feed-card__action-search-btn-none" style="cursor:none">&nbsp;</a>				
                @endif                
                <!-- <a href="#">
                    <div class="main-page-cmmn-feed-card__action-btn favorite--card-action__button">
                        <span>Interested ?</span>
                    </div>
                </a> -->
                <div class="favorite_page--cntnt__list">
                    <ul>
                        <li><i class="fas fa-coins gold-coins-color" aria-hidden="true"></i><span class="common-semibold-heading">{{$rowVal->tokens}}</span></li>
                        <li class="common-semibold-heading">{{$rowVal->expert_hrs}}hrs/wk</li>
                        <li><span class="common-semibold-heading">{{$rowVal->approved_users}}</span> of <span class="common-semibold-heading">{{(!empty($rowVal->expert_qty))?$rowVal->expert_qty:0 }}</span> candidate(s)</li>
                        <li><span class="common-semibold-heading">Reward:</span> {{$rowVal->rewards}} </li>
                    </ul>
                </div>
            </div>

            <div class="main-page-cmmn-feed-card__footer-area favorite-card__footer-area search-drawer__footer-area">
                <div class="row ">
                    <div class="col-md-1 for-common-linked-text__style">
                        @if(!empty($rowVal->image_name))
                            <a href="{{ url('profile', Crypt::encrypt($rowVal->org_uid)) }}"><div class="favorite-page-cmn-card__user-pic"  style="background: url('{{ $rowVal->image_name }}');">
                            </div></a>
                        @else
                            <a href="{{ url('profile', Crypt::encrypt($rowVal->org_uid)) }}"><i class="fas fa-user-circle fa-2x" aria-hidden="true"></i></a>
                        @endif
                    </div>
                    <div class="col-md-5 for-null-paddng-right for-common-linked-text__style">
                        <a href="{{ url('profile', Crypt::encrypt($rowVal->org_uid)) }}"><div class="main-page-cmmn-feed-card__footer-area--desg">{{$rowVal->firstName}}</div></a>
                        <div class="main-page-cmmn-feed-card__footer-area--dept">{{$rowVal->department}}</div>
                    </div>
                    @include('common.search-feed-action-card')
                </div>
            </div>
        
        </div>
    </div><!---col-md-3-ENDS----->
@endforeach
@elseif($page==1)
    <div class="container"><p>No more opportunities found!</p></div>
@endif

<script type="text/javascript">
	/** Share Opp Fxn : STARTS **/
	function initVueComponent(){
		// $shareUserList['all']
		vm = new Vue({
			el: '#vueComponent',
			data: {
				search : '',
				selectedList : [],
				postIDs : [],
				items: {!! $shareUserJsonList !!},
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
	/** Share Opp Fxn : ENDS **/
</script>

@if(isset($applicantData) && $applicantData != null)
  @php $showApprovalBtn = false;  @endphp
	@if( (in_array(config('kloves.ROLE_MANAGER'),explode(",",Auth::user()->roles))  && Auth::user()->id== $opportunity_data->org_uid ) )
    @php $showApprovalBtn = true  @endphp
  @endif
<ul class="list-applicants">
    <li>
      <div class="row">
        <div class="col-lg-7">
          <strong>Name:</strong>
        </div>
        <div class="col-lg-5">
          <strong>Action:</strong>
        </div>
      </div>
    </li>
    @foreach ($applicantData as $itemRow) 
   <li id="applicant-row-{{ $itemRow->id }}">
        <div class="row">
          <div class="col-lg-7">
            <div data-col-name="Name:">{{ $itemRow->applicant_name }}</div>
          </div>
          <div class="col-lg-5">
            <div data-col-name="Action:">
              @if($showApprovalBtn)
                @if($itemRow->action_status==0)
                  <button type="button" class="btn btn-light actionMBtn" data-applicant_id="{{  Crypt::encrypt($itemRow->applicant_id) }}" data-oppid="{{  Crypt::encrypt($itemRow->id) }}" data-action="reject" data-href="{{ url('opp-action') }}">Reject</button>

                  <button type="button" class="btn btn-light actionMBtn" data-applicant_id="{{  Crypt::encrypt($itemRow->applicant_id) }}" data-oppid="{{  Crypt::encrypt($itemRow->id) }}" data-action="approve" data-href="{{ url('opp-action') }}">Approve</button>
                @else
                  @if($itemRow->action_status==1)
                    <button type="button" class="btn btn-light"><span class="green-clr">Approved</span></button>
                  @else
                    <button type="button" class="btn btn-light"><span class="yellow-clr">Rejected</span></button>
                  @endif
                @endif
              @endif

            
              <button type="button" class="btn btn-light commentApplicant" data-applicant_id="{{  Crypt::encrypt($itemRow->applicant_id) }}" data-oppid="{{  Crypt::encrypt($itemRow->id) }}" data-target="conversation-section-{{$itemRow->id}}">Comment</button>
             
            </div>
          </div>
        </div>
        <div class="row opp-comment-form">
            <div class="row clearfix">
                <div class="col-lg-7 conversation-section-{{$itemRow->id}}">
                    @include('opportunity.post-comment')
                </div>
                <div class="col-lg-5">
                    <form class="user-comment-form" method="POST" action="{{ url('post-opp-comment') }}" data-applicant_id="{{  Crypt::encrypt($itemRow->applicant_id) }}" data-oppid="{{  Crypt::encrypt($itemRow->id) }}" data-target="conversation-section-{{$itemRow->id}}">
                          <textarea class="form-control comment_content" placeholder="I will speak with your supervisor to check and see if the dates are possible." name="comment_content" id="comment_content" required></textarea>
                          @csrf
                          <input type="hidden" name="oid" value="{{  Crypt::encrypt($itemRow->id) }}">
                          <input type="hidden" name="to_id" value="{{ (Auth::user()->id==$itemRow->applicant_id) ? Crypt::encrypt($itemRow->creator_id) :  Crypt::encrypt($itemRow->applicant_id) }}">
                          <input type="hidden" name="from_id" value="{{ (Auth::user()->id==$itemRow->applicant_id) ? Crypt::encrypt($itemRow->applicant_id) :  Crypt::encrypt($itemRow->creator_id) }}">
                          <input type="hidden" name="comment_type" value="1">
                          <button class="btn btn-light" type="submit">Post</button>
                    </form>
              </div>
          </div>
        </div>
      </li>
    @endforeach
  </ul>
@else
  <p> No applicant yet! </p>
@endif
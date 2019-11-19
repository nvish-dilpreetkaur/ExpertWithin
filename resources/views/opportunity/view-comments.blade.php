@extends('layouts.admin')
@section('content')  
@include('common.admin-nav') 
<!----------new-links-to-test-start------------------->

<section class="main-body" id="list-opportunities-page">
  <div class="container">
  <div class="opportunity-page-redesign">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="inner-oppor-wrapper">
          <div class="container inner-wrapper">
            <div class="row clearfix">
              <div class="col">
                <h1 class="opportunity-heading">{{ @$pvtcommentdata[0]->opp_title }}</h1>
              </div>
              <div class="col">
              </div>
            </div>
          </div>

          <div class="comment-list-wrapper">
                @if ($pvtcommentdata != null)
                @foreach($pvtcommentdata as $cKey1 => $cVal1)
                  <div class="row comment-outer-area">
                  <!-- <div class="comment-outer-area"> -->
                  <div class="user-profile__comment-section">
                          <i class="fas fa-user-circle"></i>
                      
                  <div class="individual-cmmnt-outer">
                    <div class="date-name-outer">
                        <div class="col cmmn-cmnt-date">{{ $cVal1->created_at }}</div>
                        <div class="col cmmn-cmnt-name">{{ $cVal1->sender }}</div>
                      </div>
                        <div class="col cmmn-cmnt-msg">{{ $cVal1->comment_content }}</div>
                  </div>
                  </div> 
                  
                  <!-- <div> -->
                </div>
                @endforeach
                @endif
          </div>
           
           
        </div>
      </div>
    </div>
  </div>
</div>
</section>

@endsection

	
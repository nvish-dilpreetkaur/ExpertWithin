
<div class="modal fade main-page__cmmn_modal" id="thumbUpModel">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Let’s begin</h4>
              <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                  <div class="modal-body">
                        <img src="{{ URL::asset('images/thumbup.png') }}"/>
                        <div id="success_message_thumbupWrapper">{!! (isset($success_message)) ? $success_message : '' !!}</div>
                   </div>
            </div>
              <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Got it</button>
            </div>
        </div>
      </div>
</div>
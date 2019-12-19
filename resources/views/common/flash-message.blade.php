@include('common.thumbup-pop-model')

<div class="col-md-12 col-sm-12">
      @if ($message = Session::get('success'))
      <div class="modal" id="success">
            <div class="modal-dialog modal-lg">
            <div class="modal-content success-modal">
            <div class="modal-header">
                  <i class="fa fa-check" aria-hidden="true"></i>
            </div>
            <div class="modal-body">
                  <h4>Success</h4>
                  <p class="success-text">{{ $message }}</p>
            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-danger success-btn" data-dismiss="modal">Got it</button>
            </div>
            </div>
            </div>
      </div>
      <script type="text/javascript">
            $('#success').modal({show:true});
      </script>
      @endif


      <div class="modal front-msg-model" id="ajaxsuccess">
            <div class="modal-dialog modal-lg">
                  <div class="modal-content success-modal">
                  <div class="modal-header">
                        <i class="fa fa-check" aria-hidden="true"></i>
                  </div>
                  <div class="modal-body">
                        <h4>Success</h4>
                        <p class="success-text">{{ $message }}</p>
                  </div>
                  <div class="modal-footer">
                        <button type="button" class="btn btn-danger success-btn" data-dismiss="modal">Got it</button>
                  </div>
                  </div>
            </div>
      </div>
</div>